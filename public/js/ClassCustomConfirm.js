class CustomConfirm {
    constructor(msg, ok) {
        this._msg = msg;
        this._ok = ok;

        this.render();
    }

    bindEvents() {
        $('#confirm-yes').on('click', _ => {
            this._ok();
            this.closeForm();
        });
        $('#confirm-no').on('click', _ => {
            this.closeForm();
        });
    }

    render() {
        this._el = $(`
            <div id="custom_confirm">
                <div class="confirm_msg">${this._msg}</div><br>
                <div class="confirm_buttons">
                    <button class="btn btn-primary" id="confirm-yes">Да</button>
                    <button class="btn btn-danger" id="confirm-no">Нет</button>            
                </div>
            </div>
        `);

        $('body').append(this._el);

        this.bindEvents();
    }

    closeForm() {
        this._el.remove();
    }


}