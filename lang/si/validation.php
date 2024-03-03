<?php

declare(strict_types=1);

return [
    'accepted'             => 'මෙම :attribute වලංගු විය යුතුය.',
    'accepted_if'          => 'මෙම :attribute, :other :value වන විට පිලිගත හැක.',
    'active_url'           => ':Attribute වලංගු නැති URL එකකි.',
    'after'                => 'මෙම :attribute, :date දිනයට පසු දිනයක් විය යුතුය.',
    'after_or_equal'       => 'මෙම :attribute, :date දිනයම හෝ ඊට පසු දිනයක් විය යුතුය.',
    'alpha'                => 'මෙම :attribute ට අඩංගු විය හැක්කේ අකුරු පමණි.',
    'alpha_dash'           => 'මෙම :attribute ට අඩංගු විය හැක්කේ අකුරු, ඉලක්කම්, කෙටිඉර හා යටිඉර පමණි.',
    'alpha_num'            => 'මෙම :attribute ට අඩංගු විය හැක්කේ අකුරු හා ඉලක්කම් පමණි.',
    'array'                => 'මේ :attribute ය array එකක් විය යුතුය.',
    'ascii'                => ':Attribute හි අඩංගු විය යුත්තේ තනි බයිට් අක්ෂරාංක අක්ෂර සහ සංකේත පමණි.',
    'before'               => 'මෙම :attribute, :date දිනයට පෙර දිනයක් විය යුතුය.',
    'before_or_equal'      => 'මෙම :attribute, :date දිනයම හෝ ඊට පෙර දිනයක් විය යුතුය.',
    'between'              => [
        'array'   => 'මෙම අන්තර්ගතය :min ත් :max ත් අතර විය යුතුය.',
        'file'    => 'මෙම ගොනුව කිලෝබයිට් :min ත් :max ත් අතර විය යුතුය.',
        'numeric' => 'මෙම සංක්‍යාව :min ත් :max ත් අතර විය යුතුය.',
        'string'  => 'මෙම වචනය අකුරු :min ත් :max ත් අතර විය යුතුය.',
    ],
    'boolean'              => 'මෙම :attribute ය සත්‍ය හෝ අසත්‍ය අගයක් විය යුතුය.',
    'can'                  => ':Attribute ක්ෂේත්රයේ අනවසර අගයක් අඩංගු වේ.',
    'confirmed'            => 'මෙම :attribute තහවුරු කිරීම නොගැලපේ.',
    'current_password'     => 'මුරපදය වලංගු නොවේ.',
    'date'                 => 'මෙම :attribute දිනය වලංගු දිනයක් නොවේ.',
    'date_equals'          => 'මෙම :attribute එක :date දිනයට සමාන දිනයක් විය යුතුය.',
    'date_format'          => 'මෙම :attribute එක :format යන ආකාරයට අනුකූල නොවේ.',
    'decimal'              => ':Attributeට දශම ස්ථාන :decimalක් තිබිය යුතුය.',
    'declined'             => ':Attribute ප්‍රතික්ෂේප කළ යුතුය.',
    'declined_if'          => ':Other :value වන විට :attribute ප්‍රතික්ෂේප කළ යුතුය.',
    'different'            => 'මෙම :attribute එක හා :other එකිනෙකට වෙනස් විය යුතුය.',
    'digits'               => 'මෙම :attribute එක ඉලක්කම් :digits ක් විය යුතුය.',
    'digits_between'       => 'මෙම :attribute එක ඉලක්කම් :min හා :max අතර විය යුතුය.',
    'dimensions'           => 'මෙම :attribute රූපය වැරදි ප්‍රමාණයන්ගෙන් ඇත.',
    'distinct'             => 'මේ :attribute හි එකම අගයේ අනු පිටපත් ඇත.',
    'doesnt_end_with'      => ':Attribute පහත සඳහන් එකකින් අවසන් නොවිය හැක: :values.',
    'doesnt_start_with'    => ':Attribute පහත සඳහන් එකකින් ආරම්භ නොවිය හැක: :values.',
    'email'                => 'මෙම :attribute එක වලංගු විද්‍යුත් ලිපිනයක් විය යුතුය.',
    'ends_with'            => 'මෙම :attribute එක :values මගින් අවසාන විය යුතුය.',
    'enum'                 => 'තෝරාගත් :attribute වලංගු නොවේ.',
    'exists'               => 'තෝරාගත් :attribute අගය වලංගු නොවේ.',
    'extensions'           => ':attribute ක්ෂේත්‍රයට පහත දිගු වලින් එකක් තිබිය යුතුය: :values.',
    'file'                 => 'මෙම :attribute ය ෆයිල් එකක් විය යුතුය.',
    'filled'               => 'මේ :attribute හි අගයක් තිබිය යුතුය.',
    'gt'                   => [
        'array'   => 'මෙම :attribute එක :value ට වඩා වැඩි අයිතම ගණනක් විය යුතුය.',
        'file'    => 'මෙම :attribute එක :value ට වඩා වැඩි කිලෝබයිට් ගණනක් විය යුතුය.',
        'numeric' => 'මෙම :attribute එක :value ට වඩා වැඩි අගයක් විය යුතුය.',
        'string'  => 'මෙම :attribute එක :value ට වඩා වැඩි අකුරු ගණනක් විය යුතුය.',
    ],
    'gte'                  => [
        'array'   => 'මෙම :attribute එක අයිතම :value ට වඩා වැඩි හෝ සමාන විය යුතුයි.',
        'file'    => 'මෙම :attribute එක කිලෝබයිට් :value ට වඩා වැඩි හෝ සමාන විය යුතුයි.',
        'numeric' => 'මෙම :attribute එක :value ට වඩා වැඩි හෝ සමාන විය යුතුයි.',
        'string'  => 'මෙම :attribute එක අකුරු :value ට වඩා වැඩි හෝ සමාන විය යුතුයි.',
    ],
    'hex_color'            => ':attribute ක්ෂේත්‍රය වලංගු ෂඩ් දශම වර්ණයක් විය යුතුය.',
    'image'                => 'මෙම :attribute රූපයක් විය යුතුය.',
    'in'                   => 'මෙම තෝරා ඇති :attribute වලංගු නැත.',
    'in_array'             => 'මෙම :attribute, :other ක්ෂේත්‍රයේ නොපවතියි.',
    'integer'              => 'මෙම :attribute පූර්ණ සංඛ්යාවක් විය යුතුය.',
    'ip'                   => 'මෙම :attribute වලංගු IP ලිපිනයක් විය යුතුය.',
    'ipv4'                 => 'මෙම :attribute වලංගු IPv4 ලිපිනය විය යුතුය.',
    'ipv6'                 => 'මෙම :attribute වලංගු IPv6 ලිපිනය විය යුතුය.',
    'json'                 => 'මෙම :attribute වලංගු JSON පේළියක් විය යුතුය.',
    'lowercase'            => ':Attribute කුඩා අකුරු විය යුතුය.',
    'lt'                   => [
        'array'   => 'මෙම :attribute එක :value ට වඩා අඩු අයිතම ගණනක් විය යුතුය.',
        'file'    => 'මෙම :attribute එක :value ට වඩා අඩු කිලෝබයිට් ගණනක් විය යුතුය.',
        'numeric' => 'මෙම :attribute එක :value ට වඩා අඩු අගයක් විය යුතුය.',
        'string'  => 'මෙම :attribute එක :value ට වඩා අඩු අකුරු ගණනක් විය යුතුය.',
    ],
    'lte'                  => [
        'array'   => 'මෙම :attribute එක අයිතම :value ට වඩා අඩු හෝ සමාන විය යුතුයි.',
        'file'    => 'මෙම :attribute එක කිලෝබයිට් :value ට වඩා අඩු හෝ සමාන විය යුතුයි.',
        'numeric' => 'මෙම :attribute එක :value ට වඩා අඩු හෝ සමාන විය යුතුයි.',
        'string'  => 'මෙම :attribute එක අකුරු :value ට වඩා අඩු හෝ සමාන විය යුතුයි.',
    ],
    'mac_address'          => ':Attribute වලංගු MAC ලිපිනයක් විය යුතුය.',
    'max'                  => [
        'array'   => 'මෙම :attribute එක :max ට වඩා වැඩි නොවිය යුතුයි.',
        'file'    => 'මෙම :attribute එක කිලෝබයිට් :max ට වඩා වැඩි නොවිය යුතුයි.',
        'numeric' => 'මෙම :attribute එක අකුරු :max ට වඩා වැඩි නොවිය යුතුයි.',
        'string'  => 'මෙම :attribute එක අයිතම :max ට වඩා වැඩි නොවිය යුතුයි.',
    ],
    'max_digits'           => ':Attribute හි ඉලක්කම් :max ට වඩා නොතිබිය යුතුය.',
    'mimes'                => 'මෙම :attribute එක: :values වර්ගයේ ගොනුවක් විය යුතුය.',
    'mimetypes'            => 'මෙම :attribute එක: :values වර්ගයේ ගොනුවක් විය යුතුය.',
    'min'                  => [
        'array'   => 'මෙම :attribute එක :min ට වඩා අඩු නොවිය යුතුයි.',
        'file'    => 'මෙම :attribute එක කිලෝබයිට් :min ට වඩා අඩු නොවිය යුතුයි.',
        'numeric' => 'මෙම :attribute එක අකුරු :min ට වඩා අඩු නොවිය යුතුයි.',
        'string'  => 'මෙම :attribute එක අයිතම :min ට වඩා අඩු නොවිය යුතුයි.',
    ],
    'min_digits'           => ':Attributeට අවම වශයෙන් ඉලක්කම් :minක්වත් තිබිය යුතුය.',
    'missing'              => ':Attribute ක්ෂේත්‍රය අතුරුදහන් විය යුතුය.',
    'missing_if'           => ':Other :value වන විට :attribute ක්ෂේත්‍රය අතුරුදහන් විය යුතුය.',
    'missing_unless'       => ':Other :value නම් මිස :attribute ක්ෂේත්‍රය අතුරුදහන් විය යුතුය.',
    'missing_with'         => ':Values ක් ඇති විට :attribute ක්ෂේත්‍රය අතුරුදහන් විය යුතුය.',
    'missing_with_all'     => ':Values ක් ඇති විට ක්ෂේත්‍ර :attribute අතුරුදහන් විය යුතුය.',
    'multiple_of'          => 'මෙම :attribute ය :value හි ගුණාකාරයක් විය යුතුය.',
    'not_in'               => 'මෙම තෝරා ඇත :attribute වලංගු නැත.',
    'not_regex'            => 'මෙම :attribute ආකෘතිය වලංගු නැත.',
    'numeric'              => 'මෙම :attribute අංකයක් විය යුතුය.',
    'password'             => [
        'letters'       => ':Attribute හි අවම වශයෙන් එක් අකුරක්වත් අඩංගු විය යුතුය.',
        'mixed'         => ':Attribute හි අවම වශයෙන් එක් ලොකු අකුරක් සහ කුඩා අකුරක් වත් අඩංගු විය යුතුය.',
        'numbers'       => ':Attribute හි අවම වශයෙන් එක් අංකයක්වත් අඩංගු විය යුතුය.',
        'symbols'       => ':Attribute හි අවම වශයෙන් එක් සංකේතයක්වත් අඩංගු විය යුතුය.',
        'uncompromised' => 'ලබා දී ඇති :attribute දත්ත කාන්දුවක පෙනී ඇත. කරුණාකර වෙනස් :attributeක් තෝරන්න.',
    ],
    'present'              => 'මෙම :attribute ක්ෂේත්‍රයේ තිබිය යුතුය.',
    'present_if'           => ':other :value වන විට :attribute ක්ෂේත්‍රය තිබිය යුතුය.',
    'present_unless'       => ':other :value නම් මිස :attribute ක්ෂේත්‍රය තිබිය යුතුය.',
    'present_with'         => ':values ක් ඇති විට :attribute ක්ෂේත්‍රය තිබිය යුතුය.',
    'present_with_all'     => 'ක්ෂේත්‍ර :values ක් ඇති විට ක්ෂේත්‍ර :attribute තිබිය යුතුය.',
    'prohibited'           => 'මෙම :attribute ක්ෂේත්‍රයේ තහනම් කර තිබේ.',
    'prohibited_if'        => ':Other, :value වන විට :attribute ක්ෂේත්‍රයේ තහනම් කර තිබේ.',
    'prohibited_unless'    => ':Other, :value නොවන්නේ නම් පමණක් :attribute ක්ෂේත්‍රයේ තහනම් කර තිබේ.',
    'prohibits'            => 'මෙම :attribute ක්ෂේත්‍රය :other පැවතීම තහනම් කර ඇත.',
    'regex'                => 'මෙම :attribute ආකෘතිය වලංගු නැත.',
    'required'             => 'මෙම :attribute ක්ෂේත්‍රයේ අවශ්‍යයි.',
    'required_array_keys'  => ':Attribute ක්ෂේත්‍රයේ: :values සඳහා ඇතුළත් කිරීම් අඩංගු විය යුතුය.',
    'required_if'          => ':Other, :value නම් පමණක් මෙම :attribute ක්ෂේත්‍රයේ අවශ්‍යයි.',
    'required_if_accepted' => ':Other පිළිගත් විට :attribute ක්ෂේත්‍රය අවශ්‍ය වේ.',
    'required_unless'      => ':Other, :value නොවන්නේ නම් පමණක් මෙම :attribute ක්ෂේත්‍රයේ අවශ්‍යයි.',
    'required_with'        => ':Values අගය පවතීනම් මෙම :attribute ක්ෂේත්‍රයේ අවශ්‍යයි.',
    'required_with_all'    => ':Values අගයන් පවතීනම් මෙම :attribute ක්ෂේත්‍රයේ අවශ්‍යයි.',
    'required_without'     => ':Values අගය නොපවතීනම් මෙම :attribute ක්ෂේත්‍රයේ අවශ්‍යයි.',
    'required_without_all' => ':Values අගයන් නොපවතීනම් මෙම :attribute ක්ෂේත්‍රයේ අවශ්‍යයි.',
    'same'                 => 'මෙම :attribute සහ :other ගැලපිය යුතුයි.',
    'size'                 => [
        'array'   => 'මෙම :attribute යේ අයිතම :size ක් තිබිය යුතුය.',
        'file'    => 'මෙම :attribute ය කිලෝබයිට් :size ක් විය යුතුය.',
        'numeric' => 'මෙම :attribute ය :size. ක් විය යුතුය.',
        'string'  => 'මෙම :attribute ය අකුරු :size විය යුතුය.',
    ],
    'starts_with'          => 'මෙම :attribute පහත සඳහන් එකක් සමඟ ආරම්භ කළ යුතුය: :values',
    'string'               => 'මෙම :attribute පේළියකි විය යුතුය.',
    'timezone'             => 'මෙම :attribute වලංගු කලාපයක් විය යුතුය.',
    'ulid'                 => ':Attribute වලංගු ULID එකක් විය යුතුය.',
    'unique'               => 'මෙම :attribute දැනටමත් අරගෙන තියෙන්නේ.',
    'uploaded'             => 'මෙම :attribute අප්ලෝඩ් කිරීම අසාර්ථක විය.',
    'uppercase'            => ':Attribute විශාල අකුරු විය යුතුය.',
    'url'                  => 'මෙම :attribute ආකෘතිය වලංගු නැත.',
    'uuid'                 => 'මෙම :attribute වලංගු UUID විය යුතුය.',
    'attributes'           => [
        'address'                  => 'ලිපිනය',
        'affiliate_url'            => 'අනුබද්ධ URL',
        'age'                      => 'වයස',
        'amount'                   => 'ප්රමාණය',
        'area'                     => 'ප්රදේශය',
        'available'                => 'ලබා ගත හැකිය',
        'birthday'                 => 'උපන් දිනය',
        'body'                     => 'අංගය',
        'city'                     => 'නගරය',
        'content'                  => 'අන්තර්ගතය',
        'country'                  => 'රට',
        'created_at'               => 'දී නිර්මාණය කරන ලදී',
        'creator'                  => 'නිර්මාතෘ',
        'currency'                 => 'මුදල්',
        'current_password'         => 'වත්මන් මුරපදය',
        'customer'                 => 'පාරිභෝගික',
        'date'                     => 'දිනය',
        'date_of_birth'            => 'උපන්දිනය',
        'day'                      => 'දවස',
        'deleted_at'               => 'දී මකා දමන ලදී',
        'description'              => 'විස්තර',
        'district'                 => 'දිසා',
        'duration'                 => 'කාල සීමාව',
        'email'                    => 'විද්යුත් තැපෑල',
        'excerpt'                  => 'උපුටා ගත් පද',
        'filter'                   => 'පෙරහන',
        'first_name'               => 'මුල් නම',
        'gender'                   => 'ස්ත්රී පුරුෂ භාවය',
        'group'                    => 'සමූහය',
        'hour'                     => 'පැය',
        'image'                    => 'රූප',
        'is_subscribed'            => 'දායක වේ',
        'items'                    => 'අයිතම',
        'last_name'                => 'අවසන් නම',
        'lesson'                   => 'පාඩම',
        'line_address_1'           => 'රේඛා ලිපිනය 1',
        'line_address_2'           => 'රේඛා ලිපිනය 2',
        'message'                  => 'පණිවුඩය',
        'middle_name'              => 'මැද නම',
        'minute'                   => 'විනාඩියක්',
        'mobile'                   => 'ජංගම දුරකථන',
        'month'                    => 'මාසය',
        'name'                     => 'නම',
        'national_code'            => 'ජාතික කේතය',
        'number'                   => 'අංකය',
        'password'                 => 'රහස් පදය',
        'password_confirmation'    => 'මුරපදය තහවුරු කිරීම',
        'phone'                    => 'දුරකථනය',
        'photo'                    => 'ඡායා රූප',
        'postal_code'              => 'තැපැල් කේතය',
        'preview'                  => 'පෙරදසුන',
        'price'                    => 'මිල',
        'product_id'               => 'නිෂ්පාදන හැඳුනුම්පත',
        'product_uid'              => 'නිෂ්පාදන UID',
        'product_uuid'             => 'නිෂ්පාදන UUID',
        'promo_code'               => 'ප්රවර්ධන කේතය',
        'province'                 => 'පළාත',
        'quantity'                 => 'ප්රමාණය',
        'recaptcha_response_field' => 'recaptcha ප්‍රතිචාර ක්ෂේත්‍රය',
        'remember'                 => 'මතක තබා ගන්න',
        'restored_at'              => 'දී ප්රතිෂ්ඨාපනය කරන ලදී',
        'result_text_under_image'  => 'රූපය යටතේ ප්රතිඵල පෙළ',
        'role'                     => 'භූමිකාව',
        'second'                   => 'දෙවැනි',
        'sex'                      => 'ස්ත්රී පුරුෂ භාවය',
        'shipment'                 => 'නැව්ගත',
        'short_text'               => 'කෙටි පෙළ',
        'size'                     => 'ප්රමාණය',
        'state'                    => 'රජයේ',
        'street'                   => 'වීදිය',
        'student'                  => 'ශිෂ්යයා',
        'subject'                  => 'විෂය',
        'teacher'                  => 'ගුරු',
        'terms'                    => 'කොන්දේසි',
        'test_description'         => 'පරීක්ෂණ විස්තරය',
        'test_locale'              => 'පරීක්ෂණ ස්ථානය',
        'test_name'                => 'පරීක්ෂණ නම',
        'text'                     => 'පෙළ',
        'time'                     => 'වේලාව',
        'title'                    => 'ශීර්ෂය',
        'updated_at'               => 'දී යාවත්කාලීන කරන ලදී',
        'user'                     => 'පරිශීලක',
        'username'                 => 'පරිශීලක නාමය',
        'year'                     => 'වර්ෂය',
    ],
];
