var Yii2Cart = {
    API: {
        init: function (user, apiRoute) {
            this.user = user;
            this.apiRoute = apiRoute;
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
        createResponseObject: function (responseString) {
            return {
                void: undefined,
                user: undefined,
                params: undefined,
                result: undefined,
                warnings: undefined,
                subresponse: function (data) {
                    return {
                        warnings: undefined,
                        result: undefined,
                        init: function (_data) {
                            var enabled = true;
                            if (data.warnings !== undefined) {
                                this.warnings = data.warnings;
                            } else {
                                enabled = false;
                            }
                            if (data.result !== undefined) {
                                this.result = data.result;
                            } else {
                                enabled = false;
                            }
                            if (enabled) {
                                return this;
                            }
                            return false;
                        }
                    };
                },
                init: function (_response) {
                    var enabled = true;
                    if (_response.void !== undefined) {
                        this.void = _response.void;
                    } else {
                        enabled = false;
                    }
                    if (_response.user !== undefined) {
                        this.user = _response.user;
                    } else {
                        enabled = false;
                    }
                    if (_response.params !== undefined) {
                        this.params = _response.params;
                    } else {
                        enabled = false;
                    }
                    if (_response.result !== undefined && $.isPlainObject(_response.result)) {
                        this.result = this.subresponse().init(_response.result);
                    } else {
                        enabled = false;
                    }
                    if (!this.result) {
                        enabled = false;
                    }
                    console.log({data: _response, response: this});
                    if (enabled) {
                        return this;
                    }

                    return false;
                }
            };
            return response.init(JSON.parse(responseString));
        },
        methods: {
            getCart: function (callback) {
                var request = Yii2Cart.API
                        .createRequestObject()
                        .setUser(Yii2Cart.API.user)
                        .setVoid('getCart');
                $.post(Yii2Cart.API.apiRoute, {json: JSON.stringify(request)}).done(function (data) {
                    return callback(Yii2Cart.API.createResponseObject().init(data));
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
                    return callback(Yii2Cart.API.createResponseObject().init(data));
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
                    return callback(Yii2Cart.API.createResponseObject().init(data));
                });
            },
            removePosition: function (position, callback) {
                var request = Yii2Cart.API
                        .createRequestObject()
                        .setUser(Yii2Cart.API.user)
                        .setVoid('removePosition')
                        .addParam('position', position);
                $.post(Yii2Cart.API.apiRoute, {json: JSON.stringify(request)}).done(function (data) {
                    return callback(Yii2Cart.API.createResponseObject().init(data));
                });
            },
            delete: function (callback) {
                var request = Yii2Cart.API
                        .createRequestObject()
                        .setUser(Yii2Cart.API.user)
                        .setVoid('remove');
                $.post(Yii2Cart.API.apiRoute, {json: JSON.stringify(request)}).done(function (data) {
                    return callback(Yii2Cart.API.createResponseObject().init(data));
                });
            }
        }
    }
};


