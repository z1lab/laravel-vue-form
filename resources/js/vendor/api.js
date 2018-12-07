import axios from 'axios'

export function searchID () {
    let path = window.location.pathname;
    let arr = path.split('/');
    return arr[arr.length - 1];
}

/**
 * @param url
 * @returns {Promise<any>}
 */
export async function getJsonChart(url) {
    try {
        let promise = new Promise((resolve, reject) => {
            axios.get(url).then(function (result) {
                resolve(result);
            })
        });

        return await promise
    } catch (error) {
        console.error(error);
    }
}

/**
 * @param parameter
 * @returns {Promise<any>}
 */
export async function getCEP(parameter) {
    try {
        let promise = new Promise((resolve, reject) => {
            let instance = axios.create()

            delete instance.defaults.headers.common['X-CSRF-TOKEN'];

            instance.get(`https://viacep.com.br/ws/${parameter}/json/`).then(function (result) {
                resolve(result);
            })
        });

        return await promise
    } catch (error) {
        console.error(error);
    }
}

/**
 * @returns {Promise<any>}
 */
export async function getStates() {
    try {
        let promise = new Promise((resolve, reject) => {
            let instance = axios.create()

            delete instance.defaults.headers.common['X-CSRF-TOKEN'];

            instance.get(`https://servicodados.ibge.gov.br/api/v1/localidades/estados`).then(function (result) {
                resolve(result);
            })
        });

        return await promise
    } catch (error) {
        console.error(error);
    }
}

/**
 * @param parameter
 * @returns {Promise<any>}
 */
export async function getCities(parameter) {
    try {
        let promise = new Promise((resolve, reject) => {
            let instance = axios.create()

            delete instance.defaults.headers.common['X-CSRF-TOKEN'];

            instance.get(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${parameter}/municipios`).then(function (result) {
                resolve(result);
            })
        });

        return await promise
    } catch (error) {
        console.error(error);
    }
}
