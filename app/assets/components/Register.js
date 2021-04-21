import React, {useEffect, useState} from 'react';
import useFetch from "../utils/useFetch";
import {Link, useHistory} from "react-router-dom";

const Register = () => {
    const [email, setEmail] = useState('')
    const [password, setPassword] = useState('')
    const [repeatPassword, setRepeatPassword] = useState('')
    const history = useHistory();
    const register = {email: email, password: {password: password, confirm: repeatPassword}};

    const {executeFetch, isLoading, error, data} = useFetch(
        '/api/register',
        {method: 'POST', body: JSON.stringify(register)},
        {immediate: false, useToken: false}
    );

    useEffect(() => {
        if (data) {
            history.push('/login');
        }
    }, [data]);

    const handleSubmit = (e) => {
        e.preventDefault();
        executeFetch()
    }

    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-3">
                    <form onSubmit={handleSubmit} method="post">
                        <h2 className="text-center">Register</h2>
                        {error && <div className="text-danger">{error}</div>}
                        <div className="form-group">
                            <label htmlFor="email">Email address</label>
                            <input
                                id="email"
                                type="text"
                                className="form-control"
                                placeholder="Email"
                                required="required"
                                value={email}
                                onChange={(e) => setEmail(e.target.value)}
                            />
                        </div>
                        <div className="form-group">
                            <label htmlFor="password">Password</label>
                            <input
                                id="password"
                                type="password"
                                className="form-control"
                                placeholder="Password"
                                required="required"
                                value={password}
                                onChange={(e) => setPassword(e.target.value)}
                            />
                        </div>
                        <div className="form-group">
                            <label htmlFor="password_repeat">Repeat Password</label>
                            <input
                                id="password_repeat"
                                type="password"
                                className="form-control"
                                placeholder="Repeat Password"
                                required="required"
                                value={repeatPassword}
                                onChange={(e) => setRepeatPassword(e.target.value)}
                            />
                        </div>
                        <div className="form-group">
                            {!isLoading &&
                            <button type="submit" className="btn btn-primary btn-block">Register</button>}
                            {isLoading &&
                            <button type="submit" className="btn btn-primary btn-block" disabled>loading...</button>}
                        </div>
                    </form>
                    <Link className="text-center" to={`/login`}>
                        <p className="text-center">Already have an account? Login</p>
                    </Link>
                </div>
            </div>
        </div>
    );
}

export default Register;