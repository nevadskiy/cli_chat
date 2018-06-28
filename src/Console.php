<?php

namespace Chat;

/**
 * Class Console
 * @package Chat
 */
class Console
{
    /**
     * @param string $question
     * @return string
     */
    public function input(string $question = '')
    {
        fwrite(STDOUT, $question);

        return trim(fgets(STDIN));
    }

    /**
     * @param string $message
     * @param bool $br
     */
    public function output(string $message, $br = false)
    {
        $br = $br ? "\n" : '';

        fwrite(STDOUT, "{$message}$br");
    }

    /**
     * @param string $overwrited
     * @param string $output
     */
    public function overwrite(string $overwrited, string $output)
    {
        $this->output("\r");
        $this->output($output, true);
        $this->output($overwrited);
    }
}