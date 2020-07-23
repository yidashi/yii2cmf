<?php

namespace common\modules\education\components;

use common\modules\education\models\Paper;
use common\modules\education\models\Question;
use PhpOffice\PhpWord\Element\Image;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\Style\Paragraph;
use PhpOffice\PhpWord\TemplateProcessor;

class PaperDoc
{
    private $paper;

    private $header;

    private $phpWord;

    private $section;

    private $fileName;

    public function __construct(Paper $paper)
    {
        $this->paper = $paper;
        $this->phpWord = new PhpWord();
        $this->section = $this->phpWord->addSection();
        $this->fileName = tempnam(Settings::getTempDir(), 'PhpWord');
    }

    public function buildHeader()
    {
        $titleStyle = ['bold' => true, 'size' => '15', 'line-height' => '2', 'name' => 'Times New Roman'];
        $subTitleStyle = ['bold' => true, 'size' => '18', 'name' => '黑体'];
        $titlePStyle = ['alignment' => 'center', 'textAlignment' => 'center'];
        $this->phpWord->addTitleStyle(1, $titleStyle, $titlePStyle);
        $this->phpWord->addTitleStyle(2, $subTitleStyle, $titlePStyle);
        $this->section->addTitle($this->paper->name, 1);
        $this->section->addTitle($this->paper->sub_name, 2);
        $this->section->addText("考试范围：xxx；考试时间：{$this->paper->test_time}分钟；命题人：xxx", [], ['alignment' => 'center']);
        $this->section->addText("注意事项：");
        $this->section->addText("1．答题前填写好自己的姓名、班级、考号等信息：");
        $this->section->addText("2．请将答案正确填写在答题卡上：");

    }

    private function buildContent()
    {
        $titleStyle = ['bold' => true, 'size' => '12', 'line-height' => '2', 'name' => '宋体 (中文标题)'];
        $titlePStyle = ['alignment' => 'center'];
        $this->section->addText("第I卷（选择题)", $titleStyle, $titlePStyle);
        $questionTitlePStyle = [];
        $this->section->addText("一、单选题", $titleStyle, $questionTitlePStyle);
        foreach ($this->paper->questions as $key => $question) {
            $questionNameText = $this->parseSimpleText($key + 1 . $question->name);
            $this->writeComplexInline($questionNameText);
            if ($question->type == Question::TYPE_RADIO) {
                $optionsSimpleText = 'A.' . $question->option_a . '	B.' . $question->option_b . '	C.' . $question->option_c . '	D.' . $question->option_d;
                $this->writeComplexInline($this->parseSimpleText($optionsSimpleText));
            }

        }
    }

    private function parseSimpleText($text)
    {
        if (preg_match_all('/\[\[(.+?)\]\]/', $text, $matches) !== false) {
            $images = $matches[1];
        } else {
            $images = [];
        }
        $result = [];
        foreach (preg_split("/\[\[|\]\]/", $text) as $item) {
            if (in_array($item, $images)) {
                $result[] = [
                    'type' => 'image',
                    'content' => $item
                ];
            } else {
                $result[] = [
                    'type' => 'text',
                    'content' => str_replace('&nbsp;', ' ', $item),
                ];
            }
        }
        return $result;
    }

    private function writeComplexInline($complexText)
    {
        $pStyle = ['textAlignment' => 'center'];
        $inline = $this->section->addTextRun($pStyle);
        foreach ($complexText as $item) {
            if ($item['type'] == 'text') {
                $inline->addText($item['content']);
            } else {
                $inline->addImage($item['content']/*, ['height' => '50']*/);
            }
        }
    }

    public function build()
    {
        $this->buildHeader();
        $this->buildContent();
    }

    public function save($fileName)
    {
        $this->build();
        $this->phpWord->save($fileName);

    }

    public function download()
    {
        $tmpFile = tempnam(Settings::getTempDir(), 'PhpWord');
        $this->save($tmpFile);
        return $tmpFile;
    }
}