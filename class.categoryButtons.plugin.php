<?php
$PluginInfo['categoryButtons'] = [
    'Name' => 'Category Buttons',
    'Description' => 'Turns the category dropdown new discussions to buttons.',
    'Version' => '0.1',
    'RequiredApplications' => ['Vanilla' => '>= 2.2'],
    'MobileFriendly' => true,
    'HasLocale' => false,
    'Author' => 'Robin Jurinka',
    'AuthorUrl' => 'http://vanillaforums.org/profile/44046/R_J',
    'License' => 'MIT'
];

class CategoryButtonsPlugin extends Gdn_Plugin {
    public function postController_render_before($sender) {
        $sender->addCssFile('categorybuttons.css', 'plugins/categoryButtons');
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
// Add credits:
// https://vanillaforums.org/addon/737/category-buttons
// https://vanillaforums.org/discussion/comment/241094/#Comment_241094
// http://viralpatel.net/blogs/css-radio-button-checkbox-background/
