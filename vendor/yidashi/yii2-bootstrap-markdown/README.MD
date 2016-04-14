## 1.安装  
```
composer require yidashi/yii2-bootstrap-markdown:"*"
```
## 2.使用  
>直接使用
  
```
<?= \yidashi\markdown\Markdown::widget(['name' => 'xxx', 'language' => 'zh'])?>
```
>或者在activeForm里使用
  
```
<?= $form->field($model,'attributeName')->widget('yidashi\markdown\Markdown',['language' => 'zh']); ?>
```
语言参数language默认就是zh，可以不提供

## 3.解析

```
<?= yii\helpers\Markdown::process($content, 'gfm')?>
```
