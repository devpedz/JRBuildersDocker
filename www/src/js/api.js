
class APIRequest {
    constructor(headers = { 'Content-Type': 'application/x-www-form-urlencoded' }, baseURL = '') {
        this.client = axios.create({
            baseURL: baseURL,
            headers: headers
        });
    }

    // Method for GET request
    async get(endpoint, params = {}) {
        try {
            const response = await this.client.get(endpoint, { params });
            return response.data;
        } catch (error) {
            this.handleError(error);
        }
    }

    // Method for POST request
    async post(endpoint, data) {
        try {
            const response = await this.client.post(endpoint, data);
            return response.data;
        } catch (error) {
            this.handleError(error);
        }
    }

    // Method for PUT request
    async put(endpoint, data) {
        try {
            const response = await this.client.put(endpoint, data);
            return response.data;
        } catch (error) {
            this.handleError(error);
        }
    }

    // Method for DELETE request
    async delete(endpoint) {
        try {
            const response = await this.client.delete(endpoint);
            return response.data;
        } catch (error) {
            this.handleError(error);
        }
    }

    // Error handling method
    handleError(error) {
        console.error('API request error:', error);
        throw new Error('An error occurred while making the API request.');
    }
}

// // Example usage of the APIRequest class
// const api = new APIRequest('');

// // Example GET request
// api.get('/data')
//   .then(data => {
//     console.log('GET data:', data);
//   })
//   .catch(error => {
//     console.error('GET error:', error);
//   });

// // Example POST request
// api.post('/data', { key: 'value' })
//   .then(data => {
//     console.log('POST data:', data);
//   })
//   .catch(error => {
//     console.error('POST error:', error);
//   });
