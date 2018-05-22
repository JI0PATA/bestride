let validation_count = 0;
let obj = [];

class Validation {
    constructor(el, regexp, errorMsg, ownFunction = null) {
        this._el = el;
        this._regexp = new RegExp(regexp);
        this._errorMsg = errorMsg;
        this._ownFunction = ownFunction;

        this._status = false;

        validation_count++;
        obj.push(this);

        this.bindEvents();
    }

    bindEvents() {
        this._el.on('change', _ => {
            this.checkOnRegExp();
        });
    }

    /**
     * Проверка по regexp
     */
    checkOnRegExp() {
        if (!this._regexp.test(this._el.val()))
            this.error();
        else
            if (this._ownFunction !== null)
                this._ownFunction();
            else
                this.success();

        this.checkActiveButton();
    }

    /**
     * Установка ошибки
     */
    error(msg = null) {
        this._status = false;

        if (msg === null) msg = this._errorMsg;

        this._el.parent().parent().addClass('has-error').removeClass('has-success');
        this._el.parent().parent().find('.error-msg').find('.help-block-error').text(msg);
    }

    /**
     * Установка успеха
     */
    success() {
        this._status = true;

        this._el.parent().parent().addClass('has-success').removeClass('has-error');
        this._el.parent().parent().find('.error-msg').find('.help-block-error').text('');
    }

    checkActiveButton() {
        obj.forEach((val, index) => {
            if (!val._status) return false;
            if (index + 1 === obj.length) {
                $('#register').removeClass('disabled').attr('type', 'submit');
            }
        });
    }


}