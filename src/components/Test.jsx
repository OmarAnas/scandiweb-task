
import { Field, Form, Formik } from "formik";

export default function Test() {
    return (
        <div>
            <h1>Sign Up</h1>
            <Formik
                initialValues={{
                    checked: [],
                }}
                onSubmit={(values) => {
                    alert(JSON.stringify(values, null, 2));
                }}
            >
                <>
                    <Form>
                        <label>
                            <Field type="checkbox" name="checked" value="One" />
                            One
                        </label>
                    </Form>
                    <Form>
                        <label>
                            <Field type="checkbox" name="checked" value="Two" />
                            Two
                        </label>
                    </Form>
                    <Form>

                        <label>
                            <Field type="checkbox" name="checked" value="Three" />
                            Three
                        </label>
                        <button type="submit">Submit</button>
                    </Form>
                </>
            </Formik>
        </div>

    );
};