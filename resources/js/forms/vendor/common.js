import {HTTP} from "../../bootstrap"
import httpBuildQuery from 'http-build-query'

/**
 * @param url
 * @param params
 * @param headers
 * @returns {Promise<any>}
 */
export async function toSeek(url, headers = {}, params = null) {
    if(params !== null) url = url + '?' + httpBuildQuery(params)

    return await new Promise((resolve, reject) => {
        HTTP.get(url, {headers: headers}).then(
            response => resolve(response.data)
        ).catch(
            e => reject(e)
        )
    })
}

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

/**
 * @param arr
 */
export function sendAlert(arr) {
    $.NotificationApp.send(arr.title, arr.message, 'top-right', 'rgba(0,0,0,0.2)', arr.type, arr.time | 3000)
}

/**
 * @param error
 */
export function exceptionError(error) {
    if (_.isObject(error.response)) {
        let message = error.response.data.errors ? error.response.data.errors.detail : error.response.data.message

        $.NotificationApp.send("Ops, algo deu errado!", message, 'top-right', 'rgba(0,0,0,0.2)', 'error')
    } else {
        console.dir(error)

        $.NotificationApp.send(
            "Algo está errado!",
            "Atualize a página e tente novamente se persistir entre em contato com a gente!",
            'top-right', 'rgba(0,0,0,0.2)', 'error'
        )
    }
}
