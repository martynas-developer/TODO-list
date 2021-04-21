import React, {useState} from 'react';
import {useHistory} from "react-router-dom";
import useFetch from "../utils/useFetch";

const TodoCreate = () => {
    const [description, setDescription] = useState('')
    const [completedAt, setCompletedAt] = useState('')
    const history = useHistory();
    const todo = {description, completedAt};
    const {executeFetch, isLoading, error} = useFetch(
        '/api/tasks',
        {method: 'POST', body: JSON.stringify(todo)},
        {immediate: false}
    );

    const handleSubmit = (e) => {
        e.preventDefault();
        executeFetch().then(() => {
            history.push('/');
        });
    }

    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-5">
                    <form onSubmit={handleSubmit} method="post">
                        <h2 className="text-center">Create new todo</h2>
                        {error && <div className="text-danger">{error}</div>}
                        <div className="form-group">
                            <label htmlFor="description">Description:</label>
                            <textarea
                                id="description"
                                className="form-control"
                                rows="3"
                                value={description}
                                onChange={(e) => setDescription(e.target.value)}
                            ></textarea>
                        </div>
                        <div className="form-group">
                            <label htmlFor="completedAt">Completed at:</label>
                            <input
                                id="completedAt"
                                type="date"
                                className="form-control"
                                value={completedAt}
                                onChange={(e) => setCompletedAt(e.target.value)}
                            />
                        </div>
                        <div className="form-group">
                            {!isLoading && <button type="submit" className="btn btn-primary btn-block">Create</button>}
                            {isLoading &&
                            <button type="submit" className="btn btn-primary btn-block" disabled>Creating...</button>}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
}

export default TodoCreate
