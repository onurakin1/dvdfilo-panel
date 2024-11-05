<?php

namespace App\Helpers;

use App\Models\Comment;
use App\Models\Country;
use App\Models\Form;
use App\Models\Language;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Post;
use App\Models\ProductCategory;
use App\Models\Setting;
use App\Models\Tag;
use DOMDocument;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class General
{


    public static function strpos_all($haystack, $needle)
    {
        $offset = 0;
        $allpos = array();
        while (($pos = strpos($haystack, $needle, $offset)) !== FALSE) {
            $offset = $pos + 1;
            $allpos[] = $pos;
        }
        return $allpos;
    }

    public static function menus($id, $parent_id = null)
    {
        $lang = Language::query()->where('code', app()->getLocale())->first();
        $menu_caches = MenuItem::with('sub_menu')->where(['menu_id' => $id, 'parent_id' => $parent_id, 'language_id' => $lang->id])->orderBy('row_number', 'ASC')->get();
        $menus = [];

        foreach ($menu_caches as $menu) {

            switch ($menu->type) {
                case 1:

                    //url
                    if (Str::substr($menu->value, 0, 4) == 'http' || Str::substr($menu->value, 0, 3) == 'www') {
                        $menu->url = url($menu->value);
                    } else {
                        $base = url()->to('');
                        $path = str_replace($base, '', $menu->value);
                        $url = $base . '/'  . $path == '/' ? '':$path;
                        $menu->url = $url;
                    }
                    break;

                case 9:
                case 10:

                    $base = url()->to('');
                    $path = str_replace($base, '', $menu->value);
                    $url = $base . '/'  . $path;
                    $menu->url = $url;
                    break;


                case 2:
                    //pages
                    $parent_slug = Page::where('slug->' . app()->getLocale(), $menu->page->slug)->first()->parent;

                    if ($parent_slug) {
                        $menu->url = $menu->page ? route('frontend.detail.' . app()->getLocale(), ['parent' => $parent_slug->slug, 'slug' => $menu->page->slug]) : '#';
                    } else {
                        $url = $menu->page ? route('frontend.detail.' . app()->getLocale(), ['slug' => $menu->page->slug]) : '#';
                        $arr_ = self::strpos_all($url, '//');
                        $menu->url = count($arr_) > 1 ? substr($url, 0, $arr_[1] + 1) . $menu->page->slug : $menu->page->slug;
                    }
                    break;
                case 3:
                    //posts
                    $menu->url = $menu->post ? route('frontend.detail.' . app()->getLocale(), $menu->post->slug) : '#';
                    break;
                case 4:
                    //product categories
                    $menu->url = $menu->category ? route('frontend.detail.' . app()->getLocale(), $menu->product_category->slug) : '#';
                    break;
                case 5:
                    //product
                    $menu->url = $menu->product ? route('frontend.detail.' . app()->getLocale(), $menu->product->slug) : '#';
                    break;
                case 6:
                    //tags
                    $menu->url = $menu->tag ? route('frontend.tag.' . app()->getLocale(), $menu->tag->slug) : '#';
                    break;
                case 7:
                    //tags
                    $menu->url = route('frontend.products.' . app()->getLocale());
                    $menu->sub_menu = ProductCategory::whereNull('parent_id')->where("lang_visible->" . app()->getLocale(), true)->orderBy('order', 'ASC')->get();
                    break;
                case 8:
                    //tags
                    $menu->url = 'seperator';
                    break;
            }
            $menu->target = $menu->link_type == 1 ? '_self' : '_target';
            $menus[] = $menu;
        }
        return $menus;
    }

    public static function last_posts()
    {
        $posts = Post::frontend(5)->get();
        return $posts;
    }

    public static function check_mime($extension)
    {
        $clear_extensions = ["jpeg", "jpg", "webp", "png", "svg", "mp4", "avif", 'pdf', 'xlsx', 'xls'];
        return Arr::first($clear_extensions, function ($value) use ($extension) {
            return $value == Str::lower($extension);
        });
    }

    public static function changeURL($url)
    {
        $newURL = str_replace('https://', 'https:/', $url);
        $newUrl2 = str_replace('//', '/', $newURL);
        return str_replace('https:/', 'https://', $newUrl2);
    }

    public static function line_to_array($string)
    {
        $array = preg_split("/\r\n|\n|\r/", $string);
        foreach ($array as $key => $item) {
            $data[$key] = [
                'icon' => "fab fa-" . Str::between($item, '.', '.'),
                'link' => $item
            ];
        }
        return json_decode(json_encode($data));
    }

    public static function get_model_name($type)
    {
        switch ($type) {
            case 1:
                return Post::class;
            case 2:
                return Comment::class;
            default:
                return false;
        }
    }

    public static function like_active($var, $data): ?string
    {
        if (auth()->user() && in_array(auth()->user()->id, $var->$data()->pluck('user_id')->toArray())) {
            return "active";
        }
        return null;
    }


    public static function generate_url($data, $route, $type)
    {
        $langs = [];
        switch ($type) {
            case 'page':

                    if ($data['page']->parent) {
                        $slug = $data['page']->slug;
                        $langs['tr'] = self::changeURL(route($route , ['parent' => $data['page']->parent->slug, 'slug' => $slug]));
                    } else {
                        $slug = $data['page']->slug;
                        $langs['tr'] = self::changeURL(route($route , ['slug' => $slug]));
                    }


                break;
            case 'category':
                foreach (cache('settings_caches')['frontend_languages'] as $key => $item) {
                    $category_slug = $data['category_detail']->getTranslation('slug', $item->code);
                    $langs[$item->code] = self::changeURL(route($route . '.' . $item->code, [$category_slug]));
                }
                break;
            case 'sub_category':
                foreach (cache('settings_caches')['frontend_languages'] as $key => $item) {
                    $parent_category_slug = $data['parent_category']->getTranslation('slug', $item->code);
                    $category_slug = $data['category_detail']->getTranslation('slug', $item->code);
                    $langs[$item->code] = self::changeURL(route($route . '.' . $item->code, [$parent_category_slug, $category_slug]));
                }
                break;
            case 'product':
                foreach (cache('settings_caches')['frontend_languages'] as $key => $item) {
                    $category_slug = $data['category']->getTranslation('slug', $item->code);
                    $sub_cat_slug = $data['sub_category']->getTranslation('slug', $item->code);

                    $product_slug = $data['products']->getTranslation('slug', $item->code);
                    $langs[$item->code] = self::changeURL(route($route . '.' . $item->code, [$category_slug, $sub_cat_slug, $product_slug]));
                }
                break;
            case 'detail':
                foreach (cache('settings_caches')['frontend_languages'] as $key => $item) {
                    $slug = $data['data']->getTranslation('slug', $item->code);
                    $langs[$item->code] = self::changeURL(route($route . '.' . $item->code, $slug));
                }
                break;
            case 'default':
                foreach (cache('settings_caches')['frontend_languages'] as $key => $item) {
                    $langs[$item->code] = self::changeURL(route($route . '.' . $item->code));
                }
                break;
        }
        return $langs;
    }


    public static function check_form($content,$type = "")
    {
        $content = Str::replace('[[', '<i>', $content);
        $content = Str::replace(']]', '</i>', $content);

        $last = self::generate_navigation($content,'i',$type);
        return $last;
    }

    public static function generate_navigation($HTML, $TAG = 'i',$type = ""): ?string
    {

        if (!$HTML) return $HTML;

        $DOM = new DOMDocument();
        libxml_use_internal_errors(true);

        $DOM->encoding = 'UTF-8';
        $uniqid = uniqid();

        $DOM->loadHTML(mb_convert_encoding($HTML, 'HTML-ENTITIES', 'UTF-8'));
        $form_html = '<div class="form_container" id="form_' . $uniqid . '"><form class="generated_form'.$type.'" data-action="' . route('frontend.generated_form_submit') . '">';

        foreach ($DOM->getElementsByTagName($TAG) as $element) {
            $form = Form::with(['items.form_type', 'items.form_size'])->where('shortcode', $element->textContent)->first();
            $text = '<i>' . $element->textContent . '</i>';
            if ($form) {
                $form_html .= '<h4>' . $form->title . '</h4>
                <p><span>' . $form->sub_title . '</span></p>
                 <span>* Required fields</span>
                <br>
                <div class="column_container">
                <input type="hidden" name="form_id" value="' . $form->id . '">
                <input type="hidden" name="lang" value="' . app()->getLocale() . '">
                <input type="hidden" name="request_name" value="' . \request()->fullUrl() . '">
                <input type="hidden" name="route_name" value="' . \request()->route()->getName() . '">
                <input type="hidden" name="parameters" value="' . (\request()->getRequestUri()) . '">
                ';
                foreach ($form->items as $key => $item) {
                    $class = $key % 2 == 1 ? 'left' : null;
                    $full = $item->form_size->name == '1_1' ? '' : 'column column_' . $item->form_size->name;
                    $required = $item->required == 1 ? 'required' : null;
                    $require_field = $required ? '*' : null;


                    $form_html .= '<div class="field_container ' . $full . ' ' . $class . '">';

                    if ($item->form_type->key != "textarea" && $item->form_type->key != "dropdown" && $item->form_type->key != "country" && $item->form_type->key != "category" && $item->form_type->key != "dropdown" && $item->form_type->key != "email" && $item->form_type->key != "checkbox" && $item->form_type->key != "radiobox") {
                        $form_html .= '<input type="' . $item->form_type->key . '" name="' . $item->key . '" placeholder="' . $item->placeholder . ' ' . $require_field . '" ' . $required . '></div>';
                    }

                    if ($item->form_type->key == "email") {
                        $form_html .= '<input class="field forced field_email" type="' . $item->form_type->key . '" name="' . $item->key . '" placeholder="' . $item->placeholder . ' ' . $require_field . '" ' . $required . '></div>';
                    }

                    if ($item->form_type->key == "textarea") {
                        $form_html .= '<textarea class="resizable field" rows="2" name="' . $item->key . '" data-title="' . $item->placeholder . ' ' . $require_field . '" placeholder="' . $item->placeholder . ' ' . $require_field . '" ' . $required . '></textarea></div>';
                    }

                    if ($item->form_type->key == "country") {
                        $form_html .= '<div class="fancy-select"><select  name="' . $item->key . '" data-key="select_' . $item->key . '" data-title="' . $item->placeholder . '" class="field forced fancified" ' . $required . '><option value="">' . $item->placeholder . ' ' . $require_field . '</option>';

                        $countries = Country::all();
                        foreach ($countries as $country) {
                            $form_html .= '<option value="' . $country->name . '">' . $country->name . '</option>';
                        }
                        $form_html .= '</select></div></div>';
                    }

                    if ($item->form_type->key == "category") {
                        $form_html .= '<div class="fancy-select"><select name="' . $item->key . '" data-key="select_' . $item->key . '" data-title="' . $item->placeholder . '" class="field forced fancified" ' . $required . '><option value="">' . $item->placeholder . ' ' . $require_field . '</option>';

                        $categories = ProductCategory::all();
                        foreach ($categories as $category) {
                            $form_html .= '<option value="' . $category->title . '">' . $category->title . '</option>';
                        }
                        $form_html .= '</select></div></div>';
                    }

                    if ($item->form_type->key == "dropdown") {

                        $form_html .= '<div class="fancy-select"><select data-key="select_' . $item->key . '" data-title="' . $item->placeholder . '" class="field forced fancified" ' . $required . '><option value="">' . $item->placeholder . ' ' . $require_field . '</option>';

                        foreach ($item->options as $option) {
                            $form_html .= '<option value="' . $option['value'] . '">' . $option[app()->getLocale()] . '</option>';
                        }
                        $form_html .= '</select></div></div>';
                    }

                    if ($item->form_type->key == "radiobox") {

                        $form_html .= '<div class="field_container radio_container" >';
                        $form_html .= "<div style='padding-bottom: 12px;' ><span style='display:inline-block' for='" . $item->title . "'>" . $item->title . "</span></divstyle>";
                        $form_html .= "<div >";
                        foreach ($item->options as $key => $option) {

                            $id = $item->key . '_' . $item->id . '_' . $key;

                            $form_html .= '<input type="radio" id="' . $id . '" class="field forced" data-title="' . $item->title . '" name="' . $item->key . '" ' . $required . ' value="' . $option[app()->getLocale()] . '"><label  for="' . $id . '"><i></i><span>' . $option[app()->getLocale()] . ' ' . $require_field . '</span></label>';
                        }
                        $form_html .= '</div></select></div></div>';
                    }

                    if ($item->form_type->key == "checkbox") {

                        foreach ($item->options as $key => $option) {

                            $id = $item->key . '_' . $item->id . '_' . $key;

                            $form_html .= '<div class="field_container radio_container"><input type="checkbox" id="' . $id . '" class="field forced" data-title="' . $item->title . '" name="' . $item->key . '" ' . $required . '><label class="w-100" for="' . $id . '"><i></i><span>' . $option[app()->getLocale()] . ' ' . $require_field . '</span></label></div>';
                        }
                        $form_html .= '</select></div></div>';
                    }


                }
                $form_html .= '<div class="field_container radio_container">
<input type="checkbox" data-key="gdpr_1" id="contact_us_gdpr_1" required class="field forced" data-title="GDPR 1" name="gdpr_1">
<label class="w-100" for="contact_us_gdpr_1"><i></i><span>' . __('I agree in processing the entered data for the reason to contact me to fulfil my request.') . ' *</span></label></div>
<div class="field_container radio_container"><input type="checkbox" required data-key="gdpr_2" id="contact_us_gdpr_2" class="field" data-title="GDPR 2" name="gdpr_2">
<label class="w-100" for="contact_us_gdpr_2"><i></i><span>' . __('I agree in processing the entered data for the reason to contact me for general marketing purposes.') . '</span></label></div>
<div class="field_container radio_container"><input type="checkbox"  required data-key="gdpr_3" id="contact_us_gdpr_3" class="field" data-title="GDPR 3" name="gdpr_3">
<label class="w-100" for="contact_us_gdpr_3"><i></i><span>' . __('I know I can withdraw anytime by sending an email to info@kaessbohrer.com.') . '</span></label></div>
<div class="button_container right_aligned"></span>
<span>By clicking send I agree to the
 <a href="https://test.kaessbohrer.com/en/privacy-policy-548-pg">Privacy Policy</a>. </span>
<button style="border:0" type="submit" class="button red generated_form_button" >' . __('SEND') . '</button>
</form>
</div></div>';
                $HTML = Str::replace($text, $form_html, $HTML);
            } else {
                $form_html = "";
                $HTML = Str::replace($text, $form_html, $HTML);
            }
        }

        return $HTML;
    }


    public static function getVideoId($url)
    {
        // URL'de "v" parametresi varsa bu parametrenin değerini döndür
        if (preg_match('/v=([^&]*)/', $url, $matches)) {
            return $matches[1];
        }

        // URL'de "v" parametresi yoksa, URL'de "youtu.be" varsa URL'den "youtu.be" sonrasındaki kısmı döndür
        if (preg_match('/youtu\.be\/([^&]*)/', $url, $matches)) {
            return $matches[1];
        }

        // Hiçbiri bulunamazsa boş bir değer döndür
        return "";
    }


}
