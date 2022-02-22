<?php
namespace OCA\OCCWeb\Controller;

use OC\MemoryInfo;
use OCP\ILogger;
use OCP\IRequest;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http\TemplateResponse;
use OC\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\OutputInterface;
use Exception;
use OC;

class OccController extends Controller
{

    private $logger;

    private $userId;

    private $application;

    private $output;

    public function __construct(ILogger $logger, $AppName, IRequest $request, $userId)
    {
        parent::__construct($AppName, $request);
        $this->logger = new OccLogger();
        $this->userId = $userId;

        $this->application = new Application(OC::$server->getConfig(), OC::$server->getEventDispatcher(), new FakeRequest(), $this->logger, OC::$server->query(MemoryInfo::class));
        $this->application->setAutoExit(false);
        $this->output = new OccOutput(OutputInterface::VERBOSITY_NORMAL, true);
        $this->application->loadCommands(new StringInput(""), $this->output);
    }

    /**
     *
     * @NoCSRFRequired
     */
    public function index()
    {
        return new TemplateResponse('occweb', 'index');
    }

    /**
     *
     * @param
     *            $input
     * @return string
     */
    private function run($input)
    {
        try {
            $this->application->run($input, $this->output);
            return $this->output->fetch();
        } catch (Exception $ex) {
            $this->logger->logException($ex);
            return "error: " . $ex->getMessage();
        }
    }

    /**
     *
     * @param string $command
     * @return DataResponse
     */
    public function cmd($command)
    {
        $this->logger->debug($command);
        $input = new StringInput($command);
        $response = $this->run($input);
        $this->logger->debug($response);
        return new DataResponse($response);
    }

    public function list()
    {
        $defs = $this->application->application->all();
        $cmds = array();
        foreach ($defs as $d) {
            array_push($cmds, $d->getName());
        }
        return new DataResponse($cmds);
    }
}

