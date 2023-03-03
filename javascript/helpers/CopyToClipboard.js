
class CopyToClipboard {

    /**
     * copy text to clipboard
     * @param _textToCopy
     */
    constructor(_textToCopy) {
        navigator.clipboard.writeText(_textToCopy).then(function() {
            $.notify(
                {
                    message: 'Copied To Clipboard'
                },
                {
                    type:'primary',
                    allow_dismiss:false,
                    newest_on_top:true,
                    mouse_over:false,
                    showProgressbar:true,
                    spacing:10,
                    timer: 100,
                    placement:{
                        from:'top',
                        align:'right'
                    },
                    offset:{
                        x:30,
                        y:30
                    },
                    delay: 500,
                    z_index:10000,
                    animate:{
                        enter:'animated bounce',
                        exit:'animated bounce'
                    }
                });
        }, function(err) {
            console.error('Failed to copy text: ', err);
        });
    }
}

export default CopyToClipboard