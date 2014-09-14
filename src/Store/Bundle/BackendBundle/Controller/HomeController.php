<?php

namespace Store\Bundle\BackendBundle\Controller;

use Store\Bundle\BackendBundle\Controller\CoreController as Controller;
use Store\Bundle\BackendBundle\Entity\AboutUs;
use Store\Bundle\BackendBundle\Entity\Store;
use Store\Bundle\BackendBundle\Form\Type\AboutUsType;
use Store\Bundle\BackendBundle\Form\Type\StoreType;
use Symfony\Component\HttpFoundation\Request;

use JMS\DiExtraBundle\Annotation as DI;

class HomeController extends Controller
{

    protected $_session;
    protected $_em;

    /**
     * @DI\InjectParams({
     *     "em" = @DI\Inject("doctrine.orm.entity_manager"),
     *     "session" = @DI\Inject("session")
     * })
     */
    public function __construct( $em , $session)
    {
        $this->_em = $em;
        $this->_session = $session;
    }

    public function homeAction( Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.context')->getToken()->getUser();

        $store = $this->get('store.repo')->findOneBy(['userId' => $user->getId() ]);

        if( NULL === $store)
        {
            $store = new Store();
        }

        $tmp_image = $store->getLogo();
        $store->setLogo(NULL);


        $em->persist($store);

        $form = $this->createNewForm( $request , new StoreType() , $store );

        if( $form->isValid())
        {

            $data = $form->getData();
            $logo = $data->getLogo();

            if( $logo)
            {

                $this->get('file.save')->remove( $tmp_image);
                $logo = $this->get('file.save')->save( $logo , 'store' );
                $store->setLogo( $logo);
            }else
            {
                $store->setLogo( $tmp_image);
            }

            $store->setUser( $user );
            $store->setCreatedAt( new \Datetime());
            $em->flush();

            $request->getSession()->getFlashBag()->add('success' , '商城更新成功');

            return $this->redirect(
                $this->generateUrl('store')
            );
        }

        $store->setLogo( $tmp_image);

        return $this->render( 'StoreBackendBundle:Home:index/index.html.twig' ,
            [
                'form' => $form->createView() ,
                'store' => $store ,
            ]
        );
    }

    public function aboutusAction(Request $request , $id = 0)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $store = $this->get('store.repo')->findOneBy(['userId' => $user->getId() ]);

        $posts = $this->get('aboutus.repo')->findBy(['storeId' => $store->getId()]);

        if( $id == 0)
        {
            $aboutus = new AboutUs();

        }else
        {
            $aboutus = $this->get('aboutus.repo')->findOneBy( ['id'=>$id,'storeId'=>$store]);
        }

        $tmp_photo = $aboutus->getPhoto();
        $aboutus->setPhoto(NULL);

        $em->persist($aboutus);
        $aboutus->setStore($store);
        $form = $this->createNewForm($request,new AboutUsType(),$aboutus);
        if( $form->isValid())
        {


            $data = $form->getData();
            $photo = $data->getPhoto();

            if($photo)
            {
                $photo = $this->get('file.save')->save($photo , 'storePost');
                if( $tmp_photo )
                {
                    $photo = $this->get('file.save')->remove($tmp_photo);
                }
            }else
            {
                $photo = $tmp_photo;
            }


            $aboutus->setPhoto($photo);
            $aboutus->setCreatedAt(new \Datetime());
            $aboutus->setEnabled(true);

            $em->flush();
            $this->addFlashMessage('success' , 'Post添加/更新成功');
            return $this->redirect($this->generateUrl('create_about_us'));
        }

        return $this->render( 'StoreBackendBundle:Home:aboutus/index.html.twig' ,
            [
                'form' => $form->createView() ,
                'posts' => $posts ,
            ]
        );
    }

    public function removeAboutAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $store = $this->get('store.repo')->findOneBy(['userId' => $user->getId() ]);
        $aboutus = $this->get('aboutus.repo')->findOneBy( ['id'=>$id,'storeId'=>$store]);

        if( $aboutus->getPhoto())
        {
            $this->get('file.save')->remove($aboutus->getPhoto());
        }

        $em->remove($aboutus);
        $em->flush();
        $this->addFlashMessage('success' , 'Post删除成功');
        return $this->redirect($this->generateUrl('create_about_us'));

    }
}