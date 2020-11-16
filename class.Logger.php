<?php

/*

 * Logger by JC Scripts - Simple and minimalistic logging framework for PHP

 * Read full documentation at https://jcscripts.online/logger

 * @version v1.0

 * Open source and free to use

 */

namespace JCScripts {

    class Logger

    {

        //Default values for core logic. Do not change 

        const DEBUG = "DEBUG";

        const INFO = "INFO";

        const WARNING = "WARNING";

        const ERROR = "ERROR";

        const FATAL = " FATAL";

        const DEFAULT_FILE = "JCLogFile.log";

        

        private $logFileHandler = null;

        private $originator = null;

        private $config = null;

        private $allowedLevels = array(self::FATAL => array(self::FATAL), self::ERROR => array(self::ERROR, self::FATAL));

        

        // Change to required values accordingly 

        const LOG_TS_FORMAT = "[d-m-Y H:i:s]";

        const LOG_INI_FILE = "logger-config.ini";

        

        // Path of output log file along with directory (and extension) 

        // Spaces are not recommended. Instead use symbols like - _

        // Example: /application/logs/JCLogfile.log 

        private $logFile = "";

        

        // Automatically called when an instance of Logger class is created 

        // Declares the log file and initializes required file handler

        public function __construct()

        {

            $this->config  = parse_ini_file(self::LOG_INI_FILE);

            $this->logFile = (!empty(trim($this->config["log_file"]))) ? $this->config["log_file"] : (self::DEFAULT_FILE);

            //$this->originator = basename(debug_backtrace()[0]['file']);

            $this->preHook();

        }

        

        // Pre hook to declare file handler to open and perform file operation 

        public function preHook()

        {

            if (null == $this->logFileHandler && !is_resource($this->logFileHandler)) {

                $this->logFileHandler = fopen($this->logFile, 'a');

            }

        }

        

        /* 

         * Method to log detailed information for debugging purpose

         * @params $message (String) - Log message

         * Example: "Value of the result - $someVariable"

         */

        

        public function debug($message)

        {

            $this->event(self::DEBUG, $message);

        }

        

        /*

         * Method to log highlevel information for the project/application

         * @params $message (String) - Log message 

         * Example: "Entered method xyz ()"

         */

        

        public function info($message)

        {

            $this->event(self::INFO, $message);

        }

        

        /*

         * Method to log warnings arised in an application

         * @params $message (String) - Log message 

         * Example: "Method xyz () is deprecated to use"

         */

        

        public function warn($message)

        {

            $this->event(self::WARNING, $message);

        }

        

        /*

         * Method to log error events arised in an application

         * @params $message (string) - Log message

         * Example: "File xyz.php is missing permissions"

         */

        

        public function error($message)

        {

            $this->event(self::ERROR, $message);

        }

        

        /*

         * Method used to log any crucial information that may cause failure to process or application

         * @params $message (string) - Log message

         * Example: "Connection to database failure"

         */

        

        public function fatal($message)

        {

            $this->event(self::FATAL, $message);

        }

        

        /*

         * Core logic to write log message to the file

         * @params $logLevel (string) Logging level

         * @params $message (String) Log message

         */

        

        private function event($logLevel, $message)

        {

            if ($this->isLevelEligible($logLevel)) {

                $this->preHook();

                $parsedMsg = date(self::LOG_TS_FORMAT) . " " . $logLevel . " (" . $this->originator . ") - " . $message . PHP_EOL;

                fwrite($this->logFileHandler, $parsedMsg);

            }

        }

        

        private function isLevelEligible($logLevel)

        {

            $isEligible = false;

            if (null != $this->config['*']) {

                if (in_array($logLevel, $this->allowedLevels[$this->config['*']])) {

                    $isEligible = true;

                }

            }

            //if(in_array($logLevel, $this->allowedLevels(

            return $isEligible;

        }

        

        /*

         * Method to safely close and free up all open resources created by Logger

         * Recommended to call this method when you are done with Logger

         */

        public function close()

        {

            unset($this->originator);

            fclose($this->logFileHandler);

            unset($this->logFileHandler);

        }

    }

}

?>
