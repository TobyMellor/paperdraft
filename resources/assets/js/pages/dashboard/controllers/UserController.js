class UserController {
    constructor() {
        this.userPreferences = [];

        this.userModel = new UserModel;
    }

    loadUserPreferences() {
        var userModel = this.userModel;

        this.userPreferences = userModel.index();

        canvasController.view.loadUserPreferences(this.userPreferences);
    }

    saveUserPreferences() {
        var userModel       = this.userModel,
            userPreferences = this.userPreferences;

        userModel.save(userPreferences);
    }

    setUserPreference(settingName, settingValue) {
        this.userPreferences[settingName] = settingValue;
    }
}