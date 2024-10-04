<?php
    require_once("../PHP/connMysql.php");

    // 獲取 categoryid
    $categoryID = isset($_GET['categoryid']) ? intval($_GET['categoryid']) : 0;
    $a = gettype($categoryID);
    echo "當前的 categoryId 是: " . htmlspecialchars($categoryID). $a;
    // SQL 查詢
    // 查詢該分類的產品資料
    $sql = "SELECT * FROM product WHERE categoryID = ?";
    // $result = $db_link->query($sql);
    $stmt = $db_link->prepare($sql);
    $stmt->bind_param("i", $categoryID); // 綁定 categoryid 參數
    $stmt->execute();
    $result = $stmt->get_result();


    // 麵包屑

    // 定義分類和父類別
    $categories = [
        1 => ['name' => '安卓手機', 'parent' => '手機平板'],
        2 => ['name' => 'iPhone', 'parent' => '手機平板'],
        3 => ['name' => '筆記型電腦', 'parent' => '電腦筆電'],
    ];

    $parentCategories = [
        '手機平板' => '3C資訊',
        '電腦筆電' => '3C資訊',
    ];
    // 定義一個陣列來存儲面包屑的連結
    $breadcrumb = [];

    // 根據 categoryID 建立面包屑
    if (array_key_exists($categoryID, $categories)) {
        // 獲取當前類別名稱和父類別
        $currentCategory = $categories[$categoryID]['name'];
        $parentCategory = $categories[$categoryID]['parent'];

        // 構建面包屑
        if (array_key_exists($parentCategory, $parentCategories)) {
            $breadcrumb[] = $parentCategories[$parentCategory];
            $breadcrumb[] = $parentCategory;
        }
        $breadcrumb[] = $currentCategory;
    }
?>

<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- css -->
    <link rel="stylesheet" href="../CSS/product_info.css">
    <!-- icon ->  fontawesome -->
    <script src="https://kit.fontawesome.com/a9eb98558e.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- {導覽列} -->
    <header class="TopHeader x">
        <nav class="myNav">
            <div class="leftMenu">
                <a class="leftMenu_a" href="../index.html">
                    <img id="logo_Small" src="../image/夢裡都有icon.png" alt="夢裡都有">
                </a>
                <form action="" id="TOP_form">
                    <input type="search" id="search_Top">
                    <button id="button_Top"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
            <ul class="rightMenu">
                <li class="rightMenu_li"><a href="login.php">登入</a></li>
                <li class="rightMenu_li"><a href="register.php">註冊</a></li>
                <li class="rightMenu_li"><a href="member_information.php">會員中心</a></li>
                <li class="rightMenu_li"><a href="#">購物車</a></li>
            </ul>
        </nav>
    </header>
    <div class="initial_header">
        <div class="myNav">
            <div class="leftMenu">
                <a class="leftMenu_a" href="../index.html">
                    <i class="fa-solid fa-house"></i>
                    回首頁
                </a>
            </div>
            <ul class="rightMenu">
                <li class="rightMenu_li"><a href="login.php">登入</a></li>
                <li class="rightMenu_li"><a href="register.php">註冊</a></li>
                <li class="rightMenu_li"><a href="member_information.php">會員中心</a></li>
                <li class="rightMenu_li"><a href="#">購物車</a></li>
            </ul>
        </div>
    </div>
    <!-- 搜尋列 -->
    <div id="header_searchBar">
        <img id="logo_Large" src="../image/夢裡都有icon_gb.png" alt="夢裡都有">
        <input id="search_main" type="search" placeholder="搜尋" autocomplete="off">
        <button class="search_Btn">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
        <div class="advert">
            <a href="">
                <img src="../image/advert.png" alt="週年廣告" class="advert_img">
            </a>
        </div>
    </div>
    <!-- 分類列 -->
    <div class="category_row">
        <ul class="category_ul">
            <li class="category_li first_li">
                <a href="" class="category_a">3C資訊</a>
                <div class="Child_category_container">
                    <ul class="Child_category_ul">
                        <li class="Child_category_li"><label class="Child_category_label">手機/平板</label></li>
                        <li class="Child_category_li"><a href="" class="Child_category_a">安卓手機</a></li>
                        <li class="Child_category_li"><a href="" class="Child_category_a">iPhone</a></li>
                        <li class="Child_category_li"><a href="" class="Child_category_a">平板電腦</a></li>
                    </ul>
                    <ul class="Child_category_ul">
                        <li class="Child_category_li"><label class="Child_category_label">電腦/筆電</label></li>
                        <li class="Child_category_li"><a href="" class="Child_category_a">筆記型電腦</a></li>
                        <li class="Child_category_li"><a href="" class="Child_category_a">桌上型電腦</a></li>
                    </ul>
                    <ul class="Child_category_ul">
                        <li class="Child_category_li"><label class="Child_category_label">資訊週邊</label></li>
                        <li class="Child_category_li"><a href="" class="Child_category_a">滑鼠</a></li>
                        <li class="Child_category_li"><a href="" class="Child_category_a">鍵盤</a></li>
                        <li class="Child_category_li"><a href="" class="Child_category_a">隨身碟</a></li>
                        <li class="Child_category_li"><a href="" class="Child_category_a">耳機</a></li>
                    </ul>
                </div>
            </li>
            <li class="category_li"><a href="" class="category_a">生活家電</a></li>
            <li class="category_li"><a href="" class="category_a">保健醫療</a></li>
            <li class="category_li"><a href="" class="category_a">美妝保養</a></li>
            <li class="category_li"><a href="" class="category_a">生活用品</a></li>
            <li class="category_li"><a href="" class="category_a">家居餐廚</a></li>
            <li class="category_li"><a href="" class="category_a">食品生鮮</a></li>
            <li class="category_li"><a href="" class="category_a">時尚精品</a></li>
        </ul>
    </div>

    
    <div class="product_container">
        <div class="prd_bread_crumbs">
                <ul>
                <?php
                    // 輸出面包屑
                    echo '<li>';
                    echo '<i class="fa-solid fa-location-dot"></i>';
                    echo '\ <a href="index.php" class="bread_crumbs">首頁</a> \ ';
                    echo implode(' \ ', array_map(function($cat) {
                        return '<span class="bread_crumbs">' . htmlspecialchars($cat) . '</span>';
                    }, $breadcrumb));
                    echo '</li>';
                    ?> 
                </ul>
        </div>
        <div class="product_block">
            <img src="" alt="" class="product_img">
            <div class="info_container">
                <p class="product_name"></p>
                <p class="product_info"></p>
                <p class="product_price"></p>
                <p class="product_quantity"></p>
                <input type="button" id="sumit_shopping_cart" value="放入購物車">
            </div>
        </div>
    </div>
    <!-- 匯入jquery -->
    <script src="../JS/jquery.min.js"></script>
    <script>
        // 分類欄滑過變色
        $('.category_li').hover(
            function() {
                $(this).find('.category_a').addClass('BGC');
            },
            function() {
                $(this).find('.category_a').removeClass('BGC');
            }
        );
    </script>
</body>

</html>