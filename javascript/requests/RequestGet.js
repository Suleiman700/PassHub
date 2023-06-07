
class RequestGet {
    constructor() {}

    /**
     * send request
     * @param _url {string} example: './php/file.php'
     * @param _data {object}
     * @param _model {string} example: performLogin
     * @return {Promise<unknown>}
     */
    send(_url, _data, _model) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: _url,
                method: "GET",
                data: {
                    ..._data,
                    model: _model
                },
                success: function(res) {
                    try {
                        const data = JSON.parse(res);
                        resolve(data)
                        // // console.log(data);
                        // if (data.status >= 200 && data.status <= 204)
                        //     resolve(data); /// after you got the callback you have to check if state(data.state) is true or false
                        // else {
                        //     reject(data);
                        // }
                    } catch {
                        console.log(res);
                        reject(res);
                    }
                },
                error: function(e) {
                    console.log(e);
                    console.log('here')
                    reject(e);
                }
            })
        })
    }
}

export default new RequestGet()