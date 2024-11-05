

export default {
    list: [
            {
                'icon': '/backend/media/menu/starter.svg',
                'title': 'Başlangıç'+window.current_route,
                'route': 'backend.dashboard',
                'is_active': 'backend.dashboard',
                'child': []
            },
            {
                'icon': '/backend/media/menu/write.svg',
                'title': 'Yazılar',
                'route': 'backend.posts.index',
                'is_active': 'backend.posts.index' ,
                'child': [
                    {
                        'title': 'Tüm Yazılar',
                        'route': 'backend.posts.create',
                        'is_active': 'backend.posts.index',
                    },
                    {
                        'title': 'Yeni Ekle',
                        'route': 'backend.posts.create',
                        'is_active': 'backend.posts.create',
                    }
                ]
            },
            {
                'icon': '/backend/media/menu/list.svg',
                'title': 'Kategoriler',
                'route': 'backend.posts.index',
                'is_active': 'backend.posts.index',
                'child': [
                    {
                        'title': 'Tüm Kategoriler',
                        'route': 'backend.posts.create',
                        'is_active': 'backend.posts.index',
                    },
                    {
                        'title': 'Yeni Ekle',
                        'route': 'backend.posts.create',
                        'is_active': 'backend.posts.create',
                    }
                ]
            },
            {
                'icon': '/backend/media/menu/upload-folder.svg',
                'title': 'Ortam',
                'route': 'backend.posts.index',
                'is_active': 'backend.posts.index',
                'child': [
                    {
                        'title': 'Kütüphane',
                        'route': 'backend.posts.index',
                        'is_active': 'backend.posts.index',
                    },
                    {
                        'title': 'Yeni Ekle',
                        'route': 'backend.posts.create',
                        'is_active': 'backend.posts.create',
                    }
                ]
            },
            {
                'icon': '/backend/media/menu/pages.svg',
                'title': 'Sayfalar',
                'route': 'backend.pages.index',
                'is_active': 'backend.pages.index',
                'child': [
                    {
                        'title': 'Tüm Sayfalar',
                        'route': 'backend.pages.index',
                        'is_active': 'backend.pages.index',
                    },
                    {
                        'title': 'Yeni Ekle',
                        'route': 'backend.pages.create',
                        'is_active': 'backend.pages.create',
                    }
                ]
            },
            {
                'icon': '/backend/media/menu/comment.svg',
                'title': 'Yorumlar',
                'route': 'backend.pages.index',
                'is_active': 'backend.pages.index',
                'child': []
            },
            {
                'icon': '/backend/media/menu/user.svg',
                'title': 'Kullanıcılar',
                'route': 'backend.users.index',
                'is_active': 'backend.users.*',
                'child': [
                    {
                        'title': 'Tüm Kullanıcılar',
                        'route': 'backend.users.index',
                        'is_active': 'backend.users.index',
                    },
                    {
                        'title': 'Yeni Ekle',
                        'route': 'backend.users.create',
                        'is_active': 'backend.users.create',
                    }
                ]
            },
        ]
}


