<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

class Medication
{
    private static function parseIngredient($dataIngredient) {
        $data = [];
        foreach($dataIngredient as $item) {
            $data[] = [
                'code' => $item['itemCodeableConcept']['coding'][0]['code'],
                'name' => $item['itemCodeableConcept']['coding'][0]['display'],
                'amount' => $item['strength']['denominator']['value'],
                'unitOfQuantity' => $item['strength']['denominator']['code'],
                'weight' => $item['strength']['numerator']['value'],
                'unitWeight' => $item['strength']['numerator']['code']
            ];
        }
        return $data;
    }

    public static function convert($response)
    {
        $data = json_decode($response->body(), true);
        $resType = $data['resourceType'];
        if ($resType == 'Medication') {
            return [
                'status' => true,
                'ihs_number' => $data['id'],
                'code' => $data['code']['coding'][0]['code'],
                'name' => $data['code']['coding'][0]['display'],
                'ingredient' => self::parseIngredient($data['ingredient'])
            ];
        }
        return Error::checkOperationOutcome($resType,$data);
    }
}