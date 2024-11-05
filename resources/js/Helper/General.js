import * as _ from 'lodash';


export default {
    ads_types(type) {
        let types = [
            {'id': 1, 'name': 'Genel Sayfalar'},
            {'id': 2, 'name': 'Ana Sayfa'},
            {'id': 3, 'name': 'Kategori Sayfaları'},
            {'id': 4, 'name': 'Yazı Sayfaları'},
            {'id': 5, 'name': 'Yazar Sayfası'},
            {'id': 6, 'name': 'Arama Sayfası'},
        ];

        if (type) {
            return types.find(({id}) => id === type);
        }

        return types;
    },
    menu_types(type) {
        let types = [
            {'id': 1, 'name': 'pages.menu.variable_url', route_name: ''},
            {'id': 2, 'name': 'pages.menu.page', route_name: 'backend.pages.fetch'},
            {'id': 3, 'name': 'pages.menu.news', route_name: 'backend.posts.fetch'},
            {'id': 4, 'name': 'pages.menu.category', route_name: 'backend.product-categories.fetch'},
            {'id': 5, 'name': 'pages.menu.product', route_name: 'backend.products.fetch'},
            {'id': 6, 'name': 'pages.menu.tag', route_name: 'backend.tags.fetch'},
            {'id': 7, 'name': 'pages.menu.category_list', route_name: ''},
            {'id': 8, 'name': 'pages.menu.seperator', route_name: ''},
            {'id': 9, 'name': 'pages.menu.find_us', route_name: ''},
            {'id': 10, 'name': 'pages.menu.video_conference', route_name: ''},
        ];

        if (type) {
            return types.find(({id}) => id === type);
        }

        return types;
    },
    sort_types(type) {
        let types = [
            {'id': 1, 'name': 'Son Yazılar'},
            {'id': 2, 'name': 'İlk Yazılar'},
            {'id': 3, 'name': 'Karışık'},
        ];

        if (type) {
            return types.find(({id}) => id === type);
        }

        return types;
    },
    block_types(type) {
        let types = [
            {'id': 1, 'name': 'Metro', 'description': 'Metro görünüm sağlar', 'code': 'metro'},
            {'id': 2, 'name': 'Sekmeler', 'description': 'Sekme görünüm sağlar', 'code': 'tab'},
            {'id': 3, 'name': 'Kayan İçerik', 'description': 'İçerikler kayan menü olarak gösterir.', 'code': 'slider'},
            {'id': 4, 'name': 'Hero Stili', 'description': 'Tek bir içeriği geniş alanda gösterir.', 'code': 'hero'},
            {'id': 5, 'name': 'Liste Görünümü', 'description': 'İçerikleri kolon şeklinde gösterir.', 'code': 'list'},
            {'id': 6, 'name': 'Metin', 'description': 'HTML şablonu gösterir.', 'code': 'text'},
        ];

        if (type) {
            return types.find(({id}) => id === type);
        }

        return types;
    },
    comment_status(status) {
        switch (status) {
            case 1:
                return '<span class="badge badge-success cursor-pointer">Onaylandı</span>';
            case 0:
                return '<span class="badge badge-danger cursor-pointer">Onay Bekliyor</span>';
        }
    },
    role: (level) => {
        switch (level) {
            case 1:
                return 'roles.sys_administration';
            case 2:
                return 'roles.manager';
            case 3:
                return 'roles.author';
            case 4:
                return 'roles.subscriber';
        }
    },
    post_status: (status) => {
        switch (status) {
            case 1:
                return 'Taslak';
            case 2:
                return 'Yayımlanmış';
            case 3:
                return 'Özel';
            case 4:
                return 'Zamanlanmış';
            case 5:
                return 'İnceleme bekliyor';
            case 6:
                return 'Çöp';
        }
    },
    generatePassword: (lowerCaseCount,
                       upperCaseCount,
                       numbersCount,
                       specialsCount) => {
        const chars = 'abcdefghijklmnopqrstuvwxyz';
        const numberChars = '0123456789';
        const specialChars = '!"£$%^&*()-=+_?';
        const pickedChars = _.sampleSize(chars, lowerCaseCount)
            .concat(_.sampleSize(chars.toUpperCase(), upperCaseCount))
            .concat(_.sampleSize(numberChars, numbersCount))
            .concat(_.sampleSize(specialChars, specialsCount));
        return _.shuffle(pickedChars).join('');
    }
}
