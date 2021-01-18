<?php

namespace app\exam\controller;

use think\Controller;
use think\Loader;
use think\Request;
use think\Validate;

class Notes extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //调用模型查询所有数据
        $data = \app\exam\model\Notes::paginate(3)->toArray();
//        print_r($data);
//        die();
        return view('show',['data'=>$data['data']]);
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //接收表单传值
        $param['title'] = $request->input('title');
        $param['editor'] = $request->input('editor');
        //验证
        $validate = new Validate($param,
            [
                'title'  =>  'require'
            ]);
        if($validate !==true){
            $this->error($validate);
        }
        //调用模型实行添加
        $data = \app\exam\model\Notes::create($param,true);
        if ($data){
            return json(['code'=>0,'msg'=>'添加成功','data'=>$data]);
        }else{
            return json(['code'=>1,'msg'=>'添加失败','data'=>'']);
        }
    }

  /**
   * 跳转到添加列表
   */
     public function add(){
      return view('add');
     }
     /**
      * 删除数据
      */
     public function delete($id){
         //验证id
         if(!is_numeric($id)){
             $this->error('参数格式错误');
         }
         //判断已发布的不能删除
         //根据id查询状态
         $data = \app\exam\model\Notes::get($id);
         if ($data['state']=='未发布'){
             //调用模型执行删除
             \app\exam\model\Notes::destroy($id);
         }else{
             return $this->error('已发布的不能删除');
         }
     }
}
