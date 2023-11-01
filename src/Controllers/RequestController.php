<?php

namespace App\Controllers;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Collections\ContactsCollection;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Models\ContactModel;
use AmoCRM\Models\CustomFieldsValues\MultitextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\MultitextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\MultitextCustomFieldValueModel;
use AmoCRM\Models\LeadModel;
use App\Services\OAuth2\OAuth2;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class RequestController
{
    private AmoCRMApiClient $apiClient;


    public function __construct()
    {
        $this->apiClient = OAuth2::setApiClient();
    }

    public function store(Request $request, Response $response): Response
    {
        $parsedDataFromForm = $request->getParsedBody();

        $lead = new LeadModel();
        $lead->setPrice($parsedDataFromForm['price']);

        $contact = new ContactModel();
        $contact->setFirstName($parsedDataFromForm['name']);

        $customFieldsValuesCollection = new CustomFieldsValuesCollection();

        // Создание поля для телефона
        $phoneField = (new MultitextCustomFieldValuesModel())->setFieldCode('PHONE');
        $multitextCustomFieldValueCollection = new MultitextCustomFieldValueCollection();
        $multitextCustomFieldModel = new MultitextCustomFieldValueModel();
        $multitextCustomFieldModel->setValue($parsedDataFromForm['phone']);
        $multitextCustomFieldValueCollection->add($multitextCustomFieldModel);
        $phoneField->setValues($multitextCustomFieldValueCollection);

        // Создание поля для почты
        $emailField = (new MultitextCustomFieldValuesModel())->setFieldCode('EMAIL');
        $multitextCustomFieldValueCollection = new MultitextCustomFieldValueCollection();
        $multitextCustomFieldModel = new MultitextCustomFieldValueModel();
        $multitextCustomFieldModel->setValue($parsedDataFromForm['email']);
        $multitextCustomFieldValueCollection->add($multitextCustomFieldModel);
        $emailField->setValues($multitextCustomFieldValueCollection);

        $customFieldsValuesCollection->add($phoneField);
        $customFieldsValuesCollection->add($emailField);


        $contact->setCustomFieldsValues($customFieldsValuesCollection);
        $responseContact = $this->apiClient->contacts()->addOne($contact);


        $contactCollection = new ContactsCollection();
        $contactCollection->add($responseContact);

        $lead->setContacts($contactCollection);

        $this->apiClient->leads()->addOne($lead);
        return $response->withHeader('Location', '/')->withStatus(302);
    }
}