import {HTTP} from "../bootstrap"

/**
 * @param url
 * @param data
 * @param headers
 * @returns {Promise<any>}
 */
export function submitFormVue(url, data, headers = {}) {

    return new Promise((resolve, reject) => {
        HTTP({
            method: 'POST',
            url: url,
            data: data,
            headers: headers
        }).then(
            response => {
                resolve(response)
            }
        ).catch(
            error => {
                reject(error)
            }
        )
    })
}
