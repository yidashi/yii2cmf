<aside class="main-sidebar">

    <section class="sidebar">


        <?= \backend\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => $leftMenuItems
            ]
        ) ?>


    </section>

</aside>
