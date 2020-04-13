<?php

namespace common\modules\education\components;

use common\modules\education\models\Paper;
use common\modules\education\models\Question;
use PhpOffice\PhpWord\TemplateProcessor;

class PaperDoc
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
        $templateProcessor->cloneBlock('essay_questions', 0, true, false, $essayQuestions);

        if (!isset($essayQuestions)) {
            $templateProcessor->deleteBlock('essay_questions');
        } else {
            $templateProcessor->cloneBlock('essay_questions', 0, true, false, $essayQuestions);
        }
        return $templateProcessor->save();
    }
}