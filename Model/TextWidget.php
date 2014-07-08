<?php
namespace Arnm\ContentBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;
/**
 * Data class for text widget form
 *
 * @author Alex Agulyansky <alex@iibspro.com>
 */
class TextWidget
{
    /**
     * Text value
     * 
     * @var string
     * 
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    private $text;
    
    /**
     * Sets the value of text
     * 
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = (string) $text;
    }
    
    /**
     * Gets the value of text
     * 
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}
