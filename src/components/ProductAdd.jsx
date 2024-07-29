import { useState, useEffect } from 'react';
import { useNavigate } from "react-router-dom";
import { ErrorMessage, Field, Form, Formik } from "formik";
import { retrieveAllTypes, retrieveProductBySKU, createProduct } from "./Api/ApiService";
import { productTypeFields, renderField } from './js/DynamicFieldBuilder';
import { initialValues, validate, onSubmit } from './js/FormHelper';

export default function ProductAdd() {

    const navigate = useNavigate();

    const [types, setTypes] = useState([]);     // sets and gets Product Types
    const [selectedValue, setSelectedValue] = useState('');     // sets and gets current selected option value 
    const [isError, setIsError] = useState(false);

    /*
    * gets all productTypes
    */
    useEffect(() => {
        retrieveAllTypes()
            .then(response => setTypes(response.data))
            .catch(error => setIsError(true));
    }, []);

    /*
    *   OnChange function for the dropdown
    */
    const optionChange = (e, setFieldValue) => {
        setSelectedValue(e.target.value);
        setFieldValue('productType', e.target);

        setFieldValue('size', ''); setFieldValue('weight', '');
        setFieldValue('length', ''); setFieldValue('width', ''); setFieldValue('height', '');
    }

    return (
        <main className="add-main-container bg-body-tertiary">
            <div className="container pt-5 pb-5">
                {!isError &&
                    <Formik initialValues={initialValues}
                        onSubmit={onSubmit(productTypeFields, createProduct, navigate)}
                        validate={validate(retrieveProductBySKU, productTypeFields)}
                        validateOnBlur={false}
                        validateOnChange={false}>
                        {({ setFieldValue, errors }) => (
                            <Form id="product_form" noValidate>
                                <div className="form-group row">
                                    <label htmlFor="sku" className="col-form-label col-sm-2">SKU<i>*</i></label>
                                    <div className="col-sm-3">
                                        <Field type="text" className={`form-control ${errors.sku && 'is-invalid'}`} name="sku" id="sku" placeholder="SKU" required />
                                        <ErrorMessage name="sku" component="div" className="invalid-feedback d-block" />
                                    </div>
                                </div>
                                <div className="form-group row">
                                    <label htmlFor="name" className="col-form-label col-sm-2">Name<i>*</i></label>
                                    <div className="col-sm-3">
                                        <Field type="text" className={`form-control ${errors.productName && 'is-invalid'}`} name="productName" id="name" placeholder="Name" required />
                                        <ErrorMessage name="productName" component="div" className="invalid-feedback d-block" />
                                    </div>
                                </div>
                                <div className="form-group row">
                                    <label htmlFor="price" className="col-form-label col-sm-2">Price ($)<i>*</i></label>
                                    <div className="col-sm-3">
                                        <Field type="number" className={`form-control ${errors.price && 'is-invalid'}`} name="price" id="price" step=".01" placeholder="Price" required />
                                        <ErrorMessage name="price" component="div" className="invalid-feedback d-block" />
                                    </div>
                                </div>
                                <div className="form-group row">
                                    <label htmlFor="productType" className="col-form-label col-sm-2">Type Switcher<i>*</i></label>
                                    <div className="col-sm-3">
                                        <Field as="select" className={`form-select ${errors.productType && 'is-invalid'}`} name="productType" id="productType"
                                            value={selectedValue} onChange={(e) => optionChange(e, setFieldValue)} required>
                                            <option id="Select" value="" disabled> Select... </option>
                                            {types.length > 0 && types.map(type => (
                                                <option key={type.id} id={type.id}> {type.type} </option>))}
                                        </Field>
                                        <ErrorMessage name="productType" component="div" className="invalid-feedback d-block" />
                                    </div>
                                </div>
                                {selectedValue && productTypeFields[selectedValue].map((field, index, array) =>
                                    renderField(field, index === array.length - 1, errors, selectedValue, Field, ErrorMessage)
                                )}
                                <p> <i>*</i> Required Fields </p>
                            </Form>
                        )}
                    </Formik>
                }
            </div >
            {
                isError &&
                <div className='main-error'>
                    <h4> Oops! We are facing an internal issue. Please visit us later! </h4>
                    <p>We are working on that issue to be solved ASAP!</p>
                </div>
            }
        </main >
    )
}