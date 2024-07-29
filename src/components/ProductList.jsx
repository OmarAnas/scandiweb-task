import { useState, useEffect } from 'react';
import { retrieveAllProducts, deleteProducts } from "./Api/ApiService";
import { Link } from "react-router-dom";
import { Field, Form, Formik } from "formik";

export default function ProductList() {

    const [products, setProducts] = useState([]);
    const [isError, setIsError] = useState(false);
    const [isLoading, setIsLoading] = useState(true);

    const retrieveProducts = () => {
        retrieveAllProducts()
            .then(response => { setProducts(response.data); setIsLoading(false); })
            .catch(error => { setIsError(true); setIsLoading(false); });
    }

    useEffect(() => {
        retrieveProducts();
    }, []);

    const DeleteSubmit = (values) => {
        if (values.deleteCheckbox.length > 0) {
            deleteProducts(values.deleteCheckbox)
                .then(response => retrieveProducts())
                .catch(error => console.error('Error deleting products:', error));
        }
    }
    if (isLoading)
        return (
            <div className='no-products'>
                <h4> Loading... </h4>
            </div>)

    return (
        <main className="list-main-container bg-body-tertiary">
            <div className="cards p-4">
                <div className="container">
                    <div className="row row-cols-md-4 g-3">
                        <Formik initialValues={{ deleteCheckbox: [] }} onSubmit={DeleteSubmit}>
                            <>
                                {(products && products.length > 0) && products.map(product => (
                                    <div className="col" key={product.id}>
                                        <div className="card shadow-sm">
                                            <div className="card-body">
                                                <div className="check-box-container">
                                                    <Form id="delete_form" >
                                                        <Field className="delete-checkbox" type="checkbox" name="deleteCheckbox" value={product.id.toString()} />
                                                    </Form>
                                                </div>
                                                <div className="product-details-container">
                                                    <p className="card-text" id="sku"> {product.sku} </p>
                                                    <p className="card-text" id="name"> {product.name} </p>
                                                    <p className="card-text" id="price"> {product.price} $</p>
                                                    <p className="card-text" id="attribute"> {product.attribute_details} </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </>
                        </Formik>
                    </div>
                </div>
            </div>

            {
                (products && products.length === 0 && !isError) &&
                <div className='main-error'>
                    <h4> No Products Added Yet. Be the First To Add! </h4>
                    <Link type="button" className="btn btn-primary shadow-sm me-5" to="/add-product"> Add Product </Link>
                </div>
            }
            {
                isError &&
                <div className='main-error'>
                    <h4> Oops! We are facing an internal issue. Please visit us later! </h4>
                    <p>We are working on that issue to be solved ASAP!</p>
                </div>
            }
        </main >
    );
};