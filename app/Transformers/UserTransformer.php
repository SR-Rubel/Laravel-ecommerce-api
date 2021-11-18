<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'identifier'=>(int)$user->id,
            'name'=>(string)$user->name,
            'email' =>(string)$user->email,
            'emailVerificationDate'=>$user->email_verified_at?(string)$user->email_verified_at:null,
            'cellPhone'=>(string)$user->phone_no,
            'creationDate' => (string)$user->created_at,
            'lastChange' => (string)$user->updated_at,
            'deletedDate' => isset($user->deleted_at) ? (string) $user->deleted_at : null,
            
            
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('profile', $user->id),
                ],
            ]
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'identifier' => 'id',
            'name' => 'name',
            'email' => 'email',
            'cellphone' =>'phone_no',
            'emailVerificationDate'=>'email_verified_at',
            'creationDate' => 'created_at',
            'lastChange' => 'updated_at',
            'deletedDate' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id'=>'identifier',
            'name'=>'name',
            'email'=>'email',
            'phone_no'=>'cellphone',
            'email_verified_at'=>'emailVericationDate',
            'created_at' => 'creationDate',
            'updated_at' => 'lastChange',
            'deleted_at' => 'deletedDate',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
