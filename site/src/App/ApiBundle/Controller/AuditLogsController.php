<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com>.
//  Copyright. All rights reserved.
//

namespace App\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\BackEndBundle\Entity\AuditLog;

class AuditLogsController extends BaseController
{
    public function indexAction(Request $request)
    {
        $entityType = $request->query->get('entity_type');
        $entityId = $request->query->get('entity_id');
        $results = $this->getDoctrine()->getRepository(AuditLog::class)->findBy(['entityType' => $entityType, 'entityId' => $entityId]);
        $translator = $this->get('translator');
        foreach ($results as $key => $result) {
            switch ($result->getAction()) {
                case 'insert':
                    $description = $translator->trans('CREATE_REGISTRY');
                    break;
                case 'update':
                    $fields = json_decode($result->getEventData(), true);
                    $descriptionArray=[];
                    foreach ($fields as $key => $field) {
                        $descriptionArray[]=$translator->trans('UPDATE_FIELD', [
                            '%field%'=>$translator->trans($this->camelCaseToSnakeCase($key))
                        ]);
                        // $descriptionArray[]=$translator->trans('UPDATE_FIELD_FROM_TO', [
                        //     '%field%'=>$translator->trans(strtoupper($key)),
                        //     '%from%'=>@$field["from"],
                        //     '%to%'=>$field["to"]
                        // ]);
                    }
                    $description = join("</br>",$descriptionArray);
                    break;
            }
            $result->setEventData($description);
        }
        return $this->handleView(
            $this->view(
                array(
                    'data' => $results
                )
            )
        );
    }

    protected function camelCaseToSnakeCase($input) {
        return strtoupper(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
    }
}