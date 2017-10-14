class UserModel {
    constructor(userPreferences) {
        this.userPreferences = userPreferences;
    }

    index() {
        return this.userPreferences;
    }

    save(userPreferences) {
        $.APIAjax({
            url: '/api/user/setting',
            type: 'POST',
            data: {
                user_preferences: userPreferences
            },
            success: function(jsonResponse) {
                this.userPreferences = userPreferences;
            },
            error: function(jsonResponse) {}
        });
    }
}