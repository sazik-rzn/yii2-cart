var Yii2Cart = {
    API: {
        init: function (user, apiRoute) {
            this.user = user;
            this.apiRoute = '/cart';
            if(apiRoute!==undefined){
                this.apiRoute = apiRoute;
            }
        },
        createRequestObject: function () {
            return {
                void: undefined,
                user: undefined,
                params: {},
                setVoid: function (voidName) {
                    this.void = voidName;
                    return this;
                },
                setUser: function (user) {
                    this.user = user;
                    return this;
                },
                addParam: function (name, value) {
                    this.params[name] = value;
                    return this;
                }
            };
        },
        methods: {
            getCart: function (callback) {
                var request = Yii2Cart.API
                        .createRequestObject()
                        .setUser(Yii2Cart.API.user)
                        .setVoid('getCart');
                $.post(Yii2Cart.API.apiRoute, {json: JSON.stringify(request)}).done(function (data) {
                    return callback(data);
                });
            },
            addPosition: function (position, count, callback) {
                var request = Yii2Cart.API
                        .createRequestObject()
                        .setUser(Yii2Cart.API.user)
                        .setVoid('addPosition')
                        .addParam('position', position)
                        .addParam('count', count);
                $.post(Yii2Cart.API.apiRoute, {json: JSON.stringify(request)}).done(function (data) {
                    return callback(data);
                });
            },
            recountPosition: function (position, count, callback) {
                var request = Yii2Cart.API
                        .createRequestObject()
                        .setUser(Yii2Cart.API.user)
                        .setVoid('recountPosition')
                        .addParam('position', position)
                        .addParam('count', count);
                $.post(Yii2Cart.API.apiRoute, {json: JSON.stringify(request)}).done(function (data) {
                    return callback(data);
                });
            },
            removePosition: function (position, callback) {
                var request = Yii2Cart.API
                        .createRequestObject()
                        .setUser(Yii2Cart.API.user)
                        .setVoid('removePosition')
                        .addParam('position', position);
                $.post(Yii2Cart.API.apiRoute, {json: JSON.stringify(request)}).done(function (data) {
                    return callback(data);
                });
            },
            delete: function (callback) {
                var request = Yii2Cart.API
                        .createRequestObject()
                        .setUser(Yii2Cart.API.user)
                        .setVoid('delete');
                $.post(Yii2Cart.API.apiRoute, {json: JSON.stringify(request)}).done(function (data) {
                    return callback(data);
                });
            }
        }
    }
};


