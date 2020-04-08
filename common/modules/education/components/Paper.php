<?php

use PhpOffice\PhpWord\TemplateProcessor;

require 'vendor/autoload.php';

$templateProcessor = new TemplateProcessor('template.docx');
$templateProcessor->setValue('paper_name', '这是一张试卷');
$templateProcessor->setValue('paper_subname', '试卷副标题');
$templateProcessor->setValue('test_time', '100');
$radioQuestions = [
    [
        'question_index' => '1',
        'question_name' => '第1道选择题',
    ],
    [
        'question_index' => '2',
        'question_name' => '第2道选择题',
    ],
    [
        'question_index' => '3',
        'question_name' => '第3道选择题',
    ],
];
$templateProcessor->cloneBlock('radio_questions', 0, true, false, $radioQuestions);
$templateProcessor->cloneBlock('fill_questions', 0, true, false, $radioQuestions);
$templateProcessor->cloneBlock('essay_questions', 0, true, false, $radioQuestions);

if (!isset($essayQuestions)) {
    $templateProcessor->deleteBlock('essay_questions');
} else {
    $templateProcessor->cloneBlock('essay_questions', 0, true, false, $radioQuestions);
}
$templateProcessor->saveAs('test.docx');
