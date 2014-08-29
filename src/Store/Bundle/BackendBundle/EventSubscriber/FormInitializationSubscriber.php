<?php

namespace Store\Bundle\BackendBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class FormInitializationSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that we want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return
        [
            FormEvents::PRE_SUBMIT => 'postSubmit'
        ];
    }

    public function postSubmit(FormEvent $event)
    {

    }
}