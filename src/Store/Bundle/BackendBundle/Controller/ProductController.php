<?php

namespace Store\Bundle\BackendBundle\Controller;

use Store\Bundle\BackendBundle\Controller\CoreController as Controller;
use Doctrine\ORM\EntityNotFoundException;
use Store\Bundle\BackendBundle\Entity\Photo;
use Store\Bundle\BackendBundle\Entity\Product;
use Store\Bundle\BackendBundle\Entity\ProductBasket;
use Store\Bundle\BackendBundle\Entity\PropertyValue;
use Store\Bundle\BackendBundle\Form\Type\ComplexProductType;
use Store\Bundle\BackendBundle\Form\Type\PhotoType;
use Store\Bundle\BackendBundle\Form\Type\ProductType;
use Store\Bundle\BackendBundle\Form\Type\PropertyValueType;
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
        if( $form->isValid())
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

    public function galleryAction( Request $request , $id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $this->getEditedProduct($id);

        //here come up with product gallery
        $photo = new Photo();
        $em->persist($photo);
        $photo->setProductBasket($product->getProductBasket());
        $photoForm = $this->createNewForm( $request , new PhotoType() , $photo );
        if( $photoForm->isValid())
        {
            $data = $photoForm->getData();
            $productPhoto = $data->getPhoto();
            $productPhoto = $this->get('file.save')->save( $productPhoto , 'productGallery');
            $photo->setPhoto( $productPhoto);
            $photo->setCreatedAt( new \Datetime());
            $em->flush();
            $request->getSession()->getFlashBag()->add('success' , '添加产品图片成功');
            return $this->redirect(
                $this->generateUrl( 'product_gallery' , ['id' => $id] )
            );
        }
        return $this->render('StoreBackendBundle:Product:gallery.html.twig' ,
            [
                'product' => $product ,
                'photoForm' => $photoForm->createView() ,
            ]
        );
    }

    public function editGalleryAction( Request $request , $id , $action)
    {
        $photo = $this->get('photo.repo')->find( $id);
        $em = $this->getDoctrine()->getManager();

        if($photo == NULL)
        {
            throw new EntityNotFoundException();
        }
        $em->persist( $photo);

        if( $action == 'enable')
        {
            $photo->setIsEnabled( true );
        }else if( $action == 'disable')
        {
            $photo->setIsEnabled( false );
        }else if( $action == 'remove')
        {
            $this->get('file.save')->remove( $photo->getPhoto() );
            $em->remove( $photo );
        }
        $em->flush();
        $request->getSession()->getFlashBag()->add('success' , '操作成功');

        return $this->redirect(
            $this->generateUrl(
                'product_gallery' , ['id' => $photo->getProductBasket()->getProduct()->getId()]
            )
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


    public function editPropertyAction( Request $request , $id , $propertyId = 0)
    {
        $em = $this->getDoctrine()->getManager();

        $product = $this->getEditedProduct($id);

        if( $propertyId > 0)
        {
            $propertyValue = $this->get('property_value.repo')->find( $propertyId);
        }else
        {
            $propertyValue = new PropertyValue();
        }


        $em->persist($propertyValue);

        $propertyValue->setProduct($product);

        $form = $this->createNewForm($request , new PropertyValueType() , $propertyValue);

        if( $form->isValid())
        {
            $em->flush();
            $this->addFlashMessage('success' , '添加/更新商品属性成功');

            return $this->redirect($this->generateUrl('edit_product_property' , ['id'=>$id] ));
        }

        $values = $this->get('property_value.repo')->createQueryBuilder('v')
                       ->select('v')
                       ->where('v.productId = '.$id)
                       ->orderBy('v.orderId' , 'asc')
                       ->getQuery()
                       ->getResult();


        return $this->render('StoreBackendBundle:Product:property/index.html.twig' ,
            [
                'product' => $product ,
                'values' => $values ,
                'form' => $form->createView() ,
            ]
        );
    }

    public function removePropertyValueAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $securityContext = $this->get('security.context');

        $value = $this->get('property_value.repo')->find( $id);

        $product = $value->getProduct();

        if (false === $securityContext->isGranted('EDIT', $product)) {
            throw new AccessDeniedException('这个商品不是你的 , 你没有编辑的权限');
        }
        $em->remove($value);
        $em->flush();
        $this->addFlashMessage('success' , '删除商品属性成功');

        return $this->redirect( $this->generateUrl('edit_product_property' , ['id'=>$product->getId()]) );
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