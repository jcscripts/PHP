Logger by JCScripts is a very simple logging framework for small PHP projects. It helps to save messages into a log file that helps to track the process flow in an 

Current version support saving messages of different logging levels
 • DEBUG - Detailed level of information
 • INFO - High-level application information
 • WARNING - Minimal errors that won't harm the system, but to be resolved
 • ERROR - Unwanted situation in an application
 • FATAL - Critical failure that might halt the application

Available methods in this framework takes message String as parameter with no return value.
 • debug(string $message) - DEBUG
 • info(string $message) - INFO
 • warn(string $message) - WARNING
 • error(string $message) - ERROR
 • fatal(string $message) - FATAL

Integration of JCScripts' Logger script is so simple. Here is what you need to do.

1) Include Logger.php file to your PHP script either by explicit include (or) auto class loader. Here is an example of explicit include.
include_once( 'Logger.php' );

2) Create an object that is an instance of Logger class under namespace 'JCScripts'
$log = new JCScripts\Logger();

3) Method from the above list, based on the type of message can be invoked over the $log object
$log->info('Entered this method');

4) Once you think you are done logging, invoke close() method on $log object to free up resources created by Logger
$log->close();

Example:
--------

<?php
include_once( 'Logger.php' );
$log = new JCScripts\Logger();

function divide($a, $b) {
$value = null;
$log->info('Entered divide() method');
$log->debug("Value of a=${a}, b=${b}");
if($b == 0) {
$log->error('Divide by zero error, parameter #2 should not be 0');
} else {
$value =$a/$b;
$log->debug("Return value is ${value}");
}
$log->info('Exit divide() method');
return $value;}
// Example call #1
echo divide(10, 2);

// Example call #2
echo divide (10, 0);
?>
