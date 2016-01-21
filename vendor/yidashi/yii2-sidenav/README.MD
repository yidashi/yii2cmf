## 1.安装

```
composer require yidashi/yii2-sidenav:"*"
```

## 2.使用

```
$items = [
  'label' => 系统管理
  'url' => #
  'items' => [
    [
      'label' => '菜单管理',
      'url' => ['/admin/menu/index']
    ],
    [
      'label' => '角色管理',
      'url' => ['/admin/role/index']
    ],
  ]
];
echo yidashi\sidenav\SideNav::widget([
  'items' => $items,
  'activeUrl' => Yii::$app->request->url // 默认是当前url，可以自己定义
]);
```
