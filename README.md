Fxbtc-php-Api
=============
Fxbtc 是国内一家比特币交易平台。(https://www.fxbtc.com/api_doc)

简单封装了一下API接口，方便大家使用。


使用方法
=============
使用fxbtc帐号生成Fxbtc对象

    $fxbtc = new Fxbtc('username', 'password');
    
使用例子：

    <?php
    include("Fxbtc.class.php");
    $fxbtc = new Fxbtc("username", "password");
    $ticker = $fxbtc->ticker(); 
    var_dump($ticker);
    ?>

依赖
=============
* PHP 5
* cURL 

捐赠
=============
1kenNNFn295AMdvV3QhAgh5Rfxcv7j4JE
