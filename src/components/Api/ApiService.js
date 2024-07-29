import { apiClient } from "./ApiClient";

export const retrieveAllProducts =
    () => apiClient.get(`/controllers/ProductsController.php?method=getAllProducts`);

export const retrieveAllTypes =
    () => apiClient.get(`/controllers/ProductsController.php?method=getAllTypes`);

export const retrieveProductBySKU =
    (sku) => apiClient.get(`/controllers/ProductsController.php?method=isProductExists&sku=${sku}`);

export const createProduct =
    (product) => apiClient.post(`/controllers/ProductsController.php?method=addProduct`, product);

export const deleteProducts =
    (ids) => apiClient.post(`/controllers/ProductsController.php?method=deleteProducts`, ids);
