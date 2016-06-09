<?php
$PluginInfo['categorySelector'] = [
    'Name' => 'Category Selector',
    'Description' => 'Turns the category dropdown in new discussions into buttons.',
    'Version' => '0.1',
    'RequiredApplications' => ['Vanilla' => '>= 2.2'],
    'MobileFriendly' => true,
    'HasLocale' => false,
    'Author' => 'Robin Jurinka',
    'AuthorUrl' => 'http://vanillaforums.org/profile/44046/R_J',
    'License' => 'MIT'
];

class CategorySelectorPlugin extends Gdn_Plugin {
    public function postController_render_before($sender) {
        $sender->addCssFile('categorybuttons.css', 'plugins/categorySelector');
    }

    public function postController_beforeFormInputs_handler($sender, $args) {
        // This prevents the default category drop down from bein rendered.
        $sender->ShowCategorySelector = false;
        $categories = CategoryModel::getByPermission();

        $categories = array_column($categories, 'Name', 'CategoryID');

        echo '<div class="P">';
        echo '<div class="Category">';
        echo $sender->Form->label('Category', 'CategoryID');
        foreach ($categories as $categoryID => $categoryName) {
            $id = 'CategoryID'.$categoryID;
            echo $sender->Form->radio(
                'CategoryID',
                '',
                [
                    'value' => $categoryID,
                    'class' => 'Hidden',
                    'id' => $id
                ]
            );
            echo $sender->Form->label(
                $categoryName,
                '',
                [
                    'class' => 'CategoryButton',
                    'for' => $id
                ]
            );
        }
        echo '</div></div>';
    }

}
