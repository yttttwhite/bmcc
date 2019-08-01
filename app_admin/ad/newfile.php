<?php
/**
* @date: 2017-4-18
* @author: hyd
* @brief:
*/
namespace app\mvc\index\ctrl;

use app\mvc\_base\ctrl\BaseCtrl;
use app\mvc\index\model\Category;
use app\mvc\index\model\MobileManuscript;

namespace app\mvc\index\ctrl;

use app\mvc\_base\ctrl\BaseCtrl;
use app\mvc\index\model\Category;
use app\mvc\index\model\MobileManuscript;

class DetailController extends BaseCtrl
{
    /**
    * @brief :
    * @author : {$author}
    * @param : $articleId
    * @return string
    */
   public function actionIndex($articleId){
        $detail = MobileManuscript::getArticleById($articleId);
        if (!empty($detail)) {
            /** 浏览量+1 */
            MobileManuscript::upReadNum($articleId);
        }
        $category = isset($detail['catid']) ? Category::getNameById($detail['catid']) : '';

        return $this->diyRender(__FUNCTION__,
            ['category' => $category],
            ['detail' => addslashes(json_encode($detail, JSON_UNESCAPED_UNICODE))]
        );
    }
}    