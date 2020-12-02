<?php

namespace app\components;

use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\log\LogRuntimeException;

/**
 * Class RequestLogger
 * @package app\components
 */
class RequestLogger extends Component
{

    /** @var string path to log file */
    public $logFile = '';

    /** {@inheritDoc} */
    public function init()
    {
        $this->logFile = \Yii::getAlias($this->logFile);
    }

    /**
     * @param $message
     * @throws InvalidConfigException
     * @throws LogRuntimeException
     */
    public function log($message)
    {
        if (($fp = @fopen($this->logFile, 'a')) === false) {
            throw new InvalidConfigException("Unable to append to log file: {$this->logFile}");
        }
        @flock($fp, LOCK_EX);
        // add date and time
        $message = date("Y-m-d H:i:s") . "\n" . $message . "\n";
        $writeResult = @fwrite($fp, $message);
        if ($writeResult === false) {
            $error = error_get_last();
            throw new LogRuntimeException("Unable to export log through file ({$this->logFile})!: {$error['message']}");
        }
        $textSize = strlen($message);
        if ($writeResult < $textSize) {
            throw new LogRuntimeException("Unable to export whole log through file ({$this->logFile})! Wrote $writeResult out of $textSize bytes.");
        }
        @flock($fp, LOCK_UN);
        @fclose($fp);
    }
}