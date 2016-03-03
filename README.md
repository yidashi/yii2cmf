###yii2 demo

> 基本是东搬西凑,到处抄来的

使用方法

```
php yii migrate  // 导入demo数据
// 如果需要采集文章,需要有redis 127.0.0.1:6379
QUEUE=* php yii queue/run &
php yii article/run tiejiong 
```