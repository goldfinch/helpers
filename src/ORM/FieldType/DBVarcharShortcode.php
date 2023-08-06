<?php

namespace Goldfinch\Helpers\ORM\FieldType;

use SilverStripe\Core\Convert;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\FieldType\DBVarchar;
use SilverStripe\View\Parsers\ShortcodeParser;

class DBVarcharShortcode extends DBVarchar
{
    private static $casting = [
        'NoSC' => 'Text',
    ];
    /**
     * Enable shortcode parsing on this field
     *
     * @var bool
     */
    protected $processShortcodes = true;

    /**
     * Check if shortcodes are enabled
     *
     * @return bool
     */
    public function getProcessShortcodes()
    {
        return $this->processShortcodes;
    }

    /**
     * Set shortcodes on or off by default
     *
     * @param bool $process
     * @return $this
     */
    public function setProcessShortcodes($process)
    {
        $this->processShortcodes = (bool)$process;
        return $this;
    }

    /**
     * @param array $options
     *
     * Options accepted in addition to those provided by Text:
     *
     *   - shortcodes: If true, shortcodes will be turned into the appropriate HTML.
     *                 If false, shortcodes will not be processed.
     *
     *   - whitelist: If provided, a comma-separated list of elements that will be allowed to be stored
     *                (be careful on relying on this for XSS protection - some seemingly-safe elements allow
     *                attributes that can be exploited, for instance <img onload="exploiting_code();" src="..." />)
     *                Text nodes outside of HTML tags are filtered out by default, but may be included by adding
     *                the text() directive. E.g. 'link,meta,text()' will allow only <link /> <meta /> and text at
     *                the root level.
     *
     * @return $this
     */
    public function setOptions(array $options = [])
    {
        if (array_key_exists("shortcodes", $options ?? [])) {
            $this->setProcessShortcodes(!!$options["shortcodes"]);
        }

        return parent::setOptions($options);
    }

    public function XML()
    {
        $value = Convert::raw2xml($this->RAW());
        $value = Convert::xml2raw($value);
        $value = Convert::raw2xml($value);

        if ($this->processShortcodes) {
            $value = ShortcodeParser::get_active()->parse($value);
        }

        return $value;
    }

    /**
     * Returns a FormField instance used as a default
     * for form scaffolding.
     *
     * Used by {@link SearchContext}, {@link ModelAdmin}, {@link DataObject::scaffoldFormFields()}
     *
     * @param string $title Optional. Localized title of the generated instance
     * @param array $params
     * @return FormField
     */
    public function scaffoldFormField($title = null, $params = null)
    {
        return TextField::create($this->name, $title)->setDescription('· allowed shortcodes: <b title="makes new line">[br]</b>');
    }

    public function NoSC()
    {
        return strip_tags($this->XML());
    }
}
