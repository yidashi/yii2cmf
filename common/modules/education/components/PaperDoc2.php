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
use PhpOffice\PhpWord\TemplateProcessor;

class PaperDoc2
{
    /**
     * @var string 试卷模板
     */
    public $template;

    private $paper;

    public function __construct(Paper $paper, $type = 1)
    {
        $this->paper = $paper;
        $this->template = dirname(__DIR__) . '/resources/template_' . $type . '.docx';
    }

    public function download()
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $inline = $section->addTextRun();
        $source = 'http://image.51siyuan.cn/3eb80d7a4d63ee6ddf1a824c6de648f4.jpg';
        $inline->addText("Remote image from");
        $inline->addImage($source, [
            'width'         => 100,
            'height'        => 100,
            'wrappingStyle' => 'inline'
        ]);
        $tmpFile = tempnam(Settings::getTempDir(), 'PhpWord');
        $phpWord->save($tmpFile);
        return $tmpFile;
    }

    public function download2()
    {
        $templateProcessor = new TemplateProcessor($this->template);
        $templateProcessor->setValue('paper_name', $this->paper->name);
        $templateProcessor->setValue('paper_sub_name', $this->paper->sub_name);
        $templateProcessor->setValue('test_time', $this->paper->test_time);
        $radioQuestions = [];
        $fillQuestions = [];
        $essayQuestions = [];
        foreach ($this->paper->questions as $key => $question) {
            if ($question->type == Question::TYPE_RADIO) {
                $radioQuestions[] = [
                    'question_index' => $key + 1,
                    'question_name' => $question->name,
                    'option_a' => $question->option_a,
                    'option_b' => $question->option_b,
                    'option_c' => $question->option_c,
                    'option_d' => $question->option_d,
                ];
            } elseif ($question->type == Question::TYPE_FILL) {
                $fillQuestions[] = [
                    'question_index' => $key + 1,
                    'question_name' => $question->name,
                ];
            } elseif ($question->type == Question::TYPE_ESSAY) {
                $essayQuestions[] = [
                    'question_index' => $key + 1,
                    'question_name' => $question->name,
                ];
            }
        }
        $templateProcessor->cloneBlock('radio_questions', 0, true, false, $radioQuestions);
        $templateProcessor->cloneBlock('fill_questions', 0, true, false, $fillQuestions);

        $inline = new TextRun();
        $inline->addImage(trim('http://image.51siyuan.cn/3eb80d7a4d63ee6ddf1a824c6de648f4.jpg'), array(
            'width'         => 100,
            'height'        => 100,
            'wrap' => 'inline'
        ));
        $inline->addText('by a red italic text', array('italic' => true, 'color' => 'red'));
        $inline->addText('by a red italic text', array('italic' => true, 'color' => 'red'));
        $templateProcessor->setComplexValue('essay_questions', $image);
        $templateProcessor->setComplexBlock('essay_questions', $inline);
        return $templateProcessor->save();
    }
}