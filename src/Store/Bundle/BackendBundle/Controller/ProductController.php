<?php

namespace Store\Bundle\BackendBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Store\Bundle\BackendBundle\Entity\Product;
use Store\Bundle\BackendBundle\Entity\ProductBasket;
use Store\Bundle\BackendBundle\Form\Type\ComplexProductType;
use Store\Bundle\BackendBundle\Form\Type\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProductController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $dispatcher = $this->get('event_dispatcher');

        $store = $this->get('store.repo')->findOneBy(['userId' => $user->getId()]);

        $product = new Product();
        $em->persist( $product);
        $form = $this->createNewForm( $request , new ProductType() , $product );

        if( $form->isValid() )
        {
            //check duplicated product
            if( $duplicatedProduct = $this->get('product.repo')->findBy([ 'productName' => $product->getProductName() ]) )
            {
                foreach( $duplicatedProduct as $p)
                {
                    if( $p->getProductBasket()->getStoreId() == $store->getId() )
                    {
                        $request->getSession()->getFlashBag()->add('danger' , '请不要重复添加商品(商品重名)');
                        return $this->redirect(
                            $this->generateUrl(
                                'product_manage'
                            )
                        );
                    }
                }

            }

            $product->setCreatedAt( new \DateTime());

            $productBasket = new ProductBasket();
            $em->persist( $productBasket);
            $productBasket->setCreatedAt( new \DateTime());
            $productBasket->setProduct( $product );
            $productBasket->setStore( $store);

            $em->flush();

            //create acl
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject( $product );
            $acl = $aclProvider->createAcl( $objectIdentity);

            //retrieving the security identity of the logging user
            $securityIdentity = UserSecurityIdentity::fromAccount( $user );

            //grant user access
            $acl->insertObjectAce( $securityIdentity , MaskBuilder::MASK_OWNER);

            $aclProvider->updateAcl( $acl );

            return $this->redirect(
                $this->generateUrl(
                    'product_manage'
                )
            );
        }

        return $this->render('StoreBackendBundle:Product:index.html.twig' ,
            [
                'form' => $form->createView() ,
                'user' => $user ,
                'store' => $store ,
            ]
        );
    }

    public function trashAction( Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();

        $store = $this->get('store.repo')->findOneBy(['userId' => $user->getId()]);

        $productBaskets = $this->get('basket.repo')->findBy(
            [
                'store' => $store->getId()
            ]
        );

        return $this->render('StoreBackendBundle:Product:trash.html.twig' ,
            [
                'productBaskets' => $productBaskets ,
            ]
        );
    }

    public function editAction(Request $request , $id)
    {

        $em = $this->getDoctrine()->getManager();

        $product = $this->getEditedProduct($id);

        $em->persist( $product );

        if( $product->getPhoto() )
        {
            $tmp_photo = $product->getPhoto();
            $product->setPhoto(NULL);
        }else
        {
            $tmp_photo = NULL;
        }

        $form = $this->createNewForm( $request , new ComplexProductType() , $product);

        if( $form->isValid() )
        {

            $data = $form->getData();

            $photo = $data->getPhoto();

            if( $photo)
            {
                if( $tmp_photo)
                {
                    $this->get('file.save')->remove( $tmp_photo);
                }

                $photo = $this->get('file.save')->save( $photo , 'product' );

                $product->setPhoto( $photo );

            }else
            {
                $product->setPhoto( $tmp_photo);
            }

            $em->flush();

            return $this->redirect(
                $this->generateUrl( 'product_edit' , ['id' => $id] )
            );

        }

        $product->setPhoto( $tmp_photo);
        return $this->render('StoreBackendBundle:Product:edit.html.twig' ,
            [
                'product' => $product ,
                'form' => $form->createView() ,
            ]
        );
    }

    public function removeAction(Request $request , $id)
    {

        $em = $this->getDoctrine()->getManager();

        $product = $this->getEditedProduct( $id);

        $productBasket = $this->get('basket.repo')->findOneBy(['productId' => $id]);

        $em->persist( $productBasket );

        $productBasket->setRemovedAt( new \Datetime());

        $em->flush();

        $request->getSession()->getFlashBag()->add('success' , '商品删除成功');

        return $this->redirect(
            $this->generateUrl(
                'product_manage'
            )
        );

    }


    public function resumeAction( Request $request , $id)
    {
        $em = $this->getDoctrine()->getManager();

        $product = $this->getEditedProduct( $id);

        $productBasket = $this->get('basket.repo')->findOneBy(['productId' => $id]);

        $em->persist( $productBasket );

        $productBasket->setRemovedAt( NULL );

        $em->flush();

        $request->getSession()->getFlashBag()->add('success' , '商品恢复成功');

        return $this->redirect(
            $this->generateUrl(
                'product_trash_manage'
            )
        );
    }

    protected function createNewForm(Request $request , AbstractType $type , $entity)
    {
        $form = $this->createForm( $type , $entity );
        $form->handleRequest( $request );
        return $form;
    }

    protected function getEditedProduct( $id)
    {
        $product = $this->get('product.repo')->find( $id);

        if( $product === NULL)
        {
            throw new EntityNotFoundException();
        }

        $securityContext = $this->get('security.context');

        // check for edit access
        if (false === $securityContext->isGranted('EDIT', $product)) {
            throw new AccessDeniedException('这个商品不是你的 , 你没有编辑的权限');
        }

        return $product;
    }
}