import axios from 'axios'

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
