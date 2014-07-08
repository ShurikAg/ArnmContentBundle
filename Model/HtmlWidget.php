<?php
namespace Arnm\ContentBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;
/**
 * Data class for text widget form
 *
 * @author Alex Agulyansky <alex@iibspro.com>
 */
class HtmlWidget
{
    /**
     * Text value
     * 
     * @var string
     * 
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    private $html;
    
    /**
     * Sets the value of html
     * 
     * @param string $html
     */
    public function setHtml($html)
    {
        $this->html = (string) $html;
    }
    
    /**
     * Gets the value of html
     * 
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }
}
