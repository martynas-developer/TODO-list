import React, {useEffect, useState} from 'react';
import useFetch from "../utils/useFetch";
import {Link} from "react-router-dom";

const Create = () => {
    const [email, setEmail] = useState('')
    const [password, setPassword] = useState('')
    const login = {email, password};
    const {executeFetch, isLoading, error, data} = useFetch(
        '/api/login',
        {method: 'POST', body: JSON.stringify(login)},
        {immediate: false, useToken:false}
    );

    useEffect(() => {
        if (data && data.token) {
            localStorage.setItem('token', data.token)
            window.location.replace('/')
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
                        <h2 className="text-center">Login</h2>
                        {error && <div className="text-danger">{error}</div>}
                        <label htmlFor="email">Email address</label>
                        <div className="form-group">
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
                            {!isLoading && <button type="submit" className="btn btn-primary btn-block">Login</button>}
                            {isLoading &&
                            <button type="submit" className="btn btn-primary btn-block" disabled>loading...</button>}
                        </div>
                    </form>
                    <Link className="text-center" to={`/register`}>
                        <p className="text-center">Don't have an account? Register</p>
                    </Link>
                </div>
            </div>
        </div>
    );
}

export default Create;