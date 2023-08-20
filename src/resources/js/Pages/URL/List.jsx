import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, useForm} from '@inertiajs/react';
import Pagination from "@/Components/Pagination.jsx";
import {useRef, useState} from "react";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import InputLabel from "@/Components/InputLabel.jsx";
import TextInput from "@/Components/TextInput.jsx";
import InputError from "@/Components/InputError.jsx";
import SecondaryButton from "@/Components/SecondaryButton.jsx";
import DangerButton from "@/Components/DangerButton.jsx";
import Modal from "@/Components/Modal.jsx";

export default function List({auth, list}) {
    const [confirmingAddNewUrl, setConfirmingAddNewUrl] = useState(false);
    const urlInput = useRef();

    const {
        data,
        setData,
        processing,
        post,
        reset,
        errors,
    } = useForm({
        destination: '',
    });

    const closeModal = () => {
        setConfirmingAddNewUrl(false);

        reset();
    };

    const addUrl = (e) => {
        e.preventDefault();

        post(route('url.post'), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => urlInput.current.focus(),
            onFinish: () => reset(),
        });
    };

    return (<AuthenticatedLayout
        user={auth.user}
        header={<div className="flow-root font-semibold text-xl text-gray-800 leading-tight">
            <p className="float-left">URLs</p>
            <p className="float-right">
                <PrimaryButton onClick={() => setConfirmingAddNewUrl(true)}>Add New Link</PrimaryButton>
            </p>
        </div>}
    >
        <Head title="URLs"/>

        <div className="py-12">
            <Modal show={confirmingAddNewUrl} onClose={closeModal}>
                <form onSubmit={addUrl} className="p-6">
                    <h2 className="text-lg font-medium text-gray-900">
                        Input your destination for shortening..
                    </h2>

                    <div className="mt-6">
                        <InputLabel htmlFor="destination" value="URL" className="sr-only"/>

                        <TextInput
                            id="destination"
                            type="text"
                            name="destination"
                            ref={urlInput}
                            value={data.destination}
                            onChange={(e) => setData('destination', e.target.value)}
                            className="mt-1 block w-3/4"
                            isFocused
                            placeholder="URL"
                        />

                        <InputError message={errors.destination} className="mt-2"/>
                    </div>

                    <div className="mt-6 flex justify-end">
                        <SecondaryButton onClick={closeModal}>Cancel</SecondaryButton>

                        <PrimaryButton className="ml-3" disabled={processing}>
                            Add URL
                        </PrimaryButton>
                    </div>
                </form>
            </Modal>

            <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div className="p-6 text-gray-900">
                        <table className="border-collapse table-auto w-full text-sm">
                            <thead>
                            <tr>
                                <th className="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">ID</th>
                                <th className="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Destination</th>
                                <th className="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Slug</th>
                                <th className="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Visits</th>
                                <th className="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Shortened
                                    URL
                                </th>
                                <th className="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Created
                                    At
                                </th>
                            </tr>
                            </thead>
                            <tbody className="bg-white dark:bg-slate-800">
                            {list.data.map((link) => {
                                return <tr key={link.id}>
                                    <td className="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{link.id}</td>
                                    <td className="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{link.destination}</td>
                                    <td className="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{link.slug}</td>
                                    <td className="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{link.visits}</td>
                                    <td className="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                        <a href={link.shortened_url} target={"_blank"}>{link.shortened_url}</a></td>
                                    <td className="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{new Date(link.created_at).toDateString()}</td>
                                </tr>;
                            })}
                            </tbody>
                        </table>

                        <Pagination class="mt-6" links={list.links}/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>);
}
