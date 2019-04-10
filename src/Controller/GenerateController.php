<?php

namespace App\Controller;

use App\Entity\ApiEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GenerateController extends AbstractController
{
    private $length;

    /**
     * @Route("/api/generate", name="generate")
     */
    public function index(Request $request)
    {
        $type = $request->query->get('type');
        $length = $request->query->get('length');

        $this->length = $length;

        if($length < 0 || $length > 128 || empty($length))
        {
           return new JsonResponse('Length less then 0 or more then 128');
        }

        switch ($type) {
            case 'string':

                $random_value = $this->generateString();
                $random_value_key = md5($random_value);
                break;

            case 'num':

                $random_value = $this->generateNumber();
                $random_value_key = md5($random_value);
                break;

            case 'numstr':

                $random_value = $this->generateNumberString();
                $random_value_key = md5($random_value);
                break;

            case 'guid':

                $random_value = $this->generateGUID();
                $random_value_key = md5($random_value);
                break;

            default:
                return new JsonResponse('Smth wrong');

        }

        $db = new ApiEntity();

        $db->setValue($random_value);
        $db->setValueKey($random_value_key);

        $this->getDoctrine()->getManager()->persist($db);
        $this->getDoctrine()->getManager()->flush();

        $end_arr = ['value' => $random_value, 'key' => $random_value_key];

        return new JsonResponse($end_arr);
    }

    private function getGUID(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12);

            return $uuid;
        }
    }

    private function generateString()
    {
        $val = '';

        for($i=0; $i<$this->length % 32; $i++ )
         $val = $val . md5(time());
        $val = preg_replace('/[0-9]+/', '', $val);

        $val = substr($val, 0, $this->length);

        return $val;
    }

    private function generateNumber()
    {
        $val = '';
        for($i=0;$i<$this->length; $i++)
        $val = $val . rand(0,9);

        return $val;
    }

    private function generateNumberString()
    {
        $val = '';

        for($i=0; $i<$this->length % 32; $i++ )
         $val = $val . md5(time());

        $val = substr($val, 0, $this->length);

        return $val;
    }

    private function generateGUID() //всегда 128 бит
    {
        $val = $this->getGUID();

        return $val;
    }

}
