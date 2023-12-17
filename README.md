
# Laravel / Lumen Collection extender

This is a set of Illuminate\Support\Collection items I use on a daily bases
[![](https://img.shields.io/github/release/i/collection-extender.svg?style=flat-square)](https://github.com/iambib/collection-extender/releases/latest)


## Install

### REQUIREMENTS
Laravel / Lumen version 9+
## Installation
```shell
    composer require iambib/collection-extender
```
### Currently available
```
$collection->recursive();
$collection->pushToKey($key, $value, ?$recursive);
$collection->toModel(?$model_class);
$collection->input($keys,?$default);
$collection->morphTo($object_class)
```


## Examples
### 1. $collection->recursive()
##### From array / multidimensional array
```
$array = [
        'foo'=>'bar',
        'bar'=>[
            'foo'=>'Lorem',
            'bar'=>'Ipsum',
        ],
    ];
```
##### to Illuminate\Support\Collection
```
Illuminate\Support\Collection {#354 ▼
  #items: array:2 [▼
    "foo" => "bar"
    "bar" => Illuminate\Support\Collection {#358 ▼
      #items: array:2 [▼
        "foo" => "Lorem"
        "bar" => "Ipsum"
      ]
      #escapeWhenCastingToString: false
    }
  ]
  #escapeWhenCastingToString: false
}
```

### 2. $collection->pushToKey('foo', 'newValue')
##### From single key value
```
Illuminate\Support\Collection {#354 ▼
  #items: array:2 [▼
    "foo" => "bar"
    "bar" => Illuminate\Support\Collection {#358 ▼
      #items: array:2 [▼
        "foo" => "Lorem"
        "bar" => "Ipsum"
      ]
      #escapeWhenCastingToString: false
    }
  ]
  #escapeWhenCastingToString: false
}
```
##### To array key value
```
Illuminate\Support\Collection {#354 ▼
  #items: array:2 [▼
    "foo" => array:2 [▼
      0 => "bar"
      1 => "newValue"
    ]
    "bar" => Illuminate\Support\Collection {#358 ▼
      #items: array:2 [▼
        "foo" => "Lorem"
        "bar" => "Ipsum"
      ]
      #escapeWhenCastingToString: false
    }
  ]
  #escapeWhenCastingToString: false
}
```
### 3. $collection->toModel works in 2 different ways
#### With model class as param
#### $collection->toModel(\App\Models\User::class)
##### From collection
```
Illuminate\Support\Collection {#352 ▼
  #items: array:2 [▼
    "foo" => "bar"
    "bar" => array:2 [▼
      "foo" => "Lorem"
      "bar" => "Ipsum"
    ]
  ]
  #escapeWhenCastingToString: false
}
```

#### or without model class as param
#### $collection->toModel()
Which will look for the key that is configured in collection-callback.php as a model_class_key
##### Config
```
return [
    'model_class_key' => 'model_name',
];

```
##### From collection
```
Illuminate\Support\Collection {#353 ▼ // packages/iambib/collection-extender/src/Providers/AppServiceProvider.php:78
  #items: array:3 [▼
    ...
    "model_name" => "App\Models\User"
  ]
  #escapeWhenCastingToString: false
}
```
##### To Model
```
App\Models\User {#360 ▼
  #attributes: array:2 [▼
    "foo" => "bar"
    "bar" => array:2 [▼
      "foo" => "Lorem"
      "bar" => "Ipsum"
    ]
  ]
  #hidden: []
  #visible: []
  #appends: []
  #fillable: []
  #guarded: []
  #casts: []
  #rememberTokenName: "remember_token"
  #autoload_relations: []
}
```
### 4. $collection->input('bar.foo')
#### $default can be string or callback
##### From collection
```
Illuminate\Support\Collection {#352 ▼
  #items: array:2 [▼
    "foo" => "bar"
    "bar" => array:2 [▼
      "foo" => "Lorem"
      "bar" => "Ipsum"
    ]
  ]
  #escapeWhenCastingToString: false
}
```
##### Returns
```
"Lorem"
```
### $collection->input('bar.foo.empty','Not found')
##### Returns
```
"Not found"
```
### 5. $collection->morphTo(ApiResponse::class)
##### Morphs current collection into an object that you need
##### From collection
```
Illuminate\Support\Collection {#354 ▼
  #items: array:3 [▼
    "status" => true
    "data" => array:2 [▼
      "foo" => "bar"
      "bar" => array:2 [▼
        "foo" => "Lorem"
        "bar" => "Ipsum"
      ]
    ]
    "message" => "Success"
  ]
  #escapeWhenCastingToString: false
}
```
##### to ApiResponse
```
ApiResponse {#361 ▼
  #status: true
  #data: array:2 [▼
    "foo" => "bar"
    "bar" => array:2 [▼
      "foo" => "Lorem"
      "bar" => "Ipsum"
    ]
  ]
  #message: "Success"
  #errors: null
}
```






# Support
Hey dude! If you like it .. well <g-emoji class="g-emoji" alias="beers" fallback-src="https://github.githubassets.com/images/icons/emoji/unicode/1f37b.png"><img class="emoji" alt="beers" height="20" width="20" src="https://github.githubassets.com/images/icons/emoji/unicode/1f37b.png"></g-emoji> or a <g-emoji class="g-emoji" alias="coffee" fallback-src="https://github.githubassets.com/images/icons/emoji/unicode/2615.png"><img class="emoji" alt="coffee" height="20" width="20" src="https://github.githubassets.com/images/icons/emoji/unicode/2615.png"></g-emoji> would be nice :D<br />

<a href="https://www.buymeacoffee.com/fhc0C7A" target="_blank" rel="nofollow"><img src="https://www.buymeacoffee.com/assets/img/custom_images/black_img.png" alt="coffee" data-canonical-src="https://www.buymeacoffee.com/assets/img/custom_images/black_img.png" style="max-width: 100%;"></a>