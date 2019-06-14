<template>
    <div>
        <div class="justify-content-end d-print-none">
            <button
                v-if="!isMobile"
                type="button"
                data-toggle="modal"
                data-target="#pdfReportModal"
                class="btn btn-info">
                <i class="fa fa-download" />
                <span class="button-text">Export Report</span>
            </button>
            <button
                v-if="isMobile"
                type="button"
                data-toggle="modal"
                data-target="#pdfReportModal"
                class="btn btn-info"
                id="mobile_button_pdf">
                <i class="fa fa-download" id="fa_mobile_pdf"/>
            </button>
        </div>
        <div
            id="pdfReportModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="pdfReportModal"
            class="modal fade"
            aria-hidden="true"
            style="display: none;">
            <div
                role="document"
                class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5
                            id="pdfReportModal"
                            class="modal-title">Select Records to Export</h5>
                        <button
                            type="button"
                            data-dismiss="modal"
                            aria-label="Close"
                            class="close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" role="alert" v-if="errors.length">
                            Please correct the following errors:
                            <ul>
                                <li v-bind:key="error" v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>
                        <div class="form-check">
                            <input
                                v-model="checkedReports"
                                type="checkbox"
                                value="TooComplaints"
                                id="tooComplaintsCheck"
                                class="form-check-input">
                            <label
                                for="tooComplaintsCheck"
                                class="form-check-label">311 Complaints (Open Data)</label>
                        </div>
                        <div class="form-check">
                            <input
                                v-model="checkedReports"
                                type="checkbox"
                                value="ComplaintsBis"
                                id="complaintsBisCheck"
                                class="form-check-input">
                            <label
                                for="complaintsBisCheck"
                                class="form-check-label">Complaints (BIS)</label>
                        </div>
                        <div class="form-check">
                            <input
                                v-model="checkedReports"
                                type="checkbox"
                                value="DobViolationsOpenData"
                                id="dobViolationsOpenDataCheck"
                                class="form-check-input">
                            <label
                                for="dobViolationsOpenDataCheck"
                                class="form-check-label">DOB Violations (Open Data)</label>
                        </div>
                        <div class="form-check">
                            <input
                                v-model="checkedReports"
                                type="checkbox"
                                value="DobViolationsBis"
                                id="dobViolationsBisCheck"
                                class="form-check-input">
                            <label
                                for="dobViolationsBisCheck"
                                class="form-check-label">DOB Violations (BIS)</label>
                        </div>
                        <div class="form-check">
                            <input
                                v-model="checkedReports"
                                type="checkbox"
                                value="EcbViolationsOpenData"
                                id="ecbViolationsOpenDataCheck"
                                class="form-check-input">
                            <label
                                for="ecbViolationsOpenDataCheck"
                                class="form-check-label">ECB Violations (Open Data)</label>
                        </div>
                        <div class="form-check">
                            <input
                                v-model="checkedReports"
                                type="checkbox"
                                value="EcbViolationsBis"
                                id="ecbViolationsBisCheck"
                                class="form-check-input">
                            <label
                                for="ecbViolationsBisCheck"
                                class="form-check-label">ECB Violations (BIS)</label>
                        </div>
                        <div class="form-check">
                            <input
                                v-model="checkedReports"
                                type="checkbox"
                                value="JobApplicationsOpenData"
                                id="jobApplicationsOpenDataCheck"
                                class="form-check-input">
                            <label
                                for="jobApplicationsOpenDataCheck"
                                class="form-check-label">Job Applications (Open Data)</label>
                        </div>
                        <div class="form-check">
                            <input
                                v-model="checkedReports"
                                type="checkbox"
                                value="JobApplicationsBis"
                                id="jobApplicationsBisCheck"
                                class="form-check-input">
                            <label
                                for="jobApplicationsBisCheck"
                                class="form-check-label">Job Applications (BIS)</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            v-if="!isLoading && checkedReports.length"
                            type="submit"
                            class="btn btn-info"
                            @click.prevent.stop.once="onClick()">
                            Generate PDF
                        </button>
                        <button
                            type="button"
                            v-if='isLoading || !checkedReports.length'
                            class="btn btn-info"
                            aria-disabled="true"
                            disabled>
                                <div v-if="isLoading">
                                    <i class="fa fa-spinner fa-spin fa-7x"></i>
                                    Please wait...
                                </div>
                                <div v-if="!checkedReports.length">
                                    Generate PDF
                                </div>
                        </button>
                        <button
                            type="button"
                            data-dismiss="modal"
                            class="btn btn-secondary">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import pdfMake from 'pdfmake/build/pdfmake.js'
import pdfFonts from './pdf_report_fonts.js'
import moment from 'moment'

pdfMake.vfs = pdfFonts.pdfMake.vfs

export default {
    props: ['zone', 'property'],
    data: function data() {
        return {
            thisZone: this.zone,
            isMobile: this.$parent.isMobile,
            isLoading: false,
            checkedReports: [],
            errors: []
        }
    },
    methods: {
        formatDate (value) { 
            if (value) { 
                return moment(String(value)).format('MM/DD/YYYY')
            }
        },
        onClick() {
            this.validateForm()
            if (!this.errors.length) {
                this.onLoading()
                this.handleCreatingPdf()
            } 
        },
        validateForm() {
            if (!this.checkedReports.length) {
                const error = 'Make a selection.'
                this.errors.push(error)
            }
        },
        onLoading() {
            if (this.isLoading) this.isLoading = false
            else this.isLoading = true
        },
        async handleCreatingPdf() {
            let content = []
            let data
            let checkedReports = this.checkedReports
            content.push(this.generalTable())
            content.push(this.zoningTable())
            if (checkedReports.includes('TooComplaints')) {
                let data = await this.getData().tooComplaints
                if (data.length) content.push(this.tooComplaintsTable(data))
            }
            if (checkedReports.includes('ComplaintsBis')) {
                let data = await this.getData().complaintsBisData
                if (data.length) content.push(this.complaintsBisTable(data))
            }
            if (checkedReports.includes('DobViolationsOpenData')) {
                let data = await this.getData().dobViolationsOpenData
                if (data.length) content.push(this.dobViolationsOpenDataTable(data))
            }
            if (checkedReports.includes('DobViolationsBis')) {
                let data = await this.getData().dobViolationsBis
                if (data.length) content.push(this.dobViolationsBisTable(data))
            }
            if (checkedReports.includes('TooComplaints')) {
                let data = await this.getData().ecbViolationsOpenData
                if (data.length) content.push(this.ecbViolationsOpenDataTable(data))
            }
            if (checkedReports.includes('EcbViolationsBis')) {
                let data = await this.getData().ecbViolationsBis
                if (data.length) content.push(this.ecbViolationsBisTable(data))
            }
            if (checkedReports.includes('JobApplicationsOpenData')) {
                let data = await this.getData().jobApplicationsOpenData
                if (data.length) content.push(this.jobApplicationsOpenDataTable(data))
            }
            if (checkedReports.includes('JobApplicationsBis')) {
                let data = await this.getData().jobApplicationsBis
                if (data.length) content.push(this.jobApplicationsBisTable(data))
            }
            this.createPdf(content)
        },
        getData() {
            return {
                'tooComplaints': axios.get(`/api/property/open-data/311-complaints/swipe/${this.property.id}`)
                    .then((response) => response.data).catch((error) => console.log(error)),
                'complaintsBisData': axios.get(`/api/property/bis/complaints/swipe/${this.property.id}`)
                    .then((response) => response.data).catch((error) => console.log(error)),
                'dobViolationsOpenData': axios.get(`/api/property/open-data/dob-violations/swipe/${this.property.id}`)
                    .then((response) => response.data).catch((error) => console.log(error)),
                'dobViolationsBis': axios.get(`/api/property/bis/dob-violations/swipe/${this.property.id}`)
                    .then((response) => response.data).catch((error) => console.log(error)),
                'ecbViolationsOpenData': axios.get(`/api/property/open-data/ecb-violations/swipe/${this.property.id}`)
                    .then((response) => response.data).catch((error) => console.log(error)),
                'ecbViolationsBis': axios.get(`/api/property/bis/ecb-violations/swipe/${this.property.id}`)
                    .then((response) => response.data).catch((error) => console.log(error)),
                'jobApplicationsOpenData': axios.get(`/api/property/open-data/job-applications/swipe/${this.property.id}`)
                    .then((response) => response.data).catch((error) => console.log(error)),
                'jobApplicationsBis': axios.get(`/api/property/bis/job-applications/swipe/${this.property.id}`)
                    .then((response) => response.data).catch((error) => console.log(error)),
            }
        },
        createPdf(content) {
            content.unshift([this.pdfContent().propertyOverview, this.pdfContent().address])
            content.unshift(this.pdfContent().logo)
            let pdfContent = { content: content }
            pdfMake.fonts = this.pdfStyles().fonts
            let docDefinition = {
                pageOrientation: this.pdfStyles().pageOrientation,
                pageSize: this.pdfStyles().pageSize,
                pageMargins: this.pdfStyles().pageMargins,
                background: this.pdfStyles().pageBackground,
                content: pdfContent.content,
                styles: this.pdfStyles().custom,
                defaultStyle: this.pdfStyles().default
            }
            pdfMake.createPdf(docDefinition).download(this.property.address, (() => { this.onLoading() }))
        },
        pdfStyles() {
            return {
                'pageBackground': function headerColor(pagenumber, pagecount) {
                    if (pagenumber === 1) {
                        return {canvas: [{ type: 'rect', x: 0, y: 0, w: 841.89, h: 595.28, color: '#ebedf2' }, { type: 'rect', x: 0, y: 0, w: 841.89, h: 70, color: '#2c2e3d' }]}
                    }
                    else return {canvas: [{ type: 'rect', x: 0, y: 0, w: 841.89, h: 595.28, color: '#ebedf2' }]}
                },
                'pageSize': {
                    width: 841.89,
                    height: 595.28
                },
                'pageMargins': [20, 15, 20, 15],
                'pageOrientation': 'landscape',
                'fonts': {
                    Poppins: {
                        normal: 'Poppins-Light.ttf',
                        bold: 'Poppins-Medium.ttf'
                    },
                    Roboto: {
                        normal: 'Roboto-Regular.ttf',
                        bold: 'Roboto-Medium.ttf'
                    }
                },
                'custom': {
                    documentHeader: {
                        fillColor: '#303140'
                    },
                    header: {
                        font: 'Roboto',
                        fontSize: 15,
                        bold: false,
                        margin: [0, 60, 0, 5]
                    },
                    subheader: {
                        font: 'Roboto',
                        fontSize: 17,
                        bold: true,
                        margin: [0, 5, 0, 20]
                    },
                    table: {
                        color: '#575962',
                        margin: [0, 0, 0, 25]
                    },
                    tableHeaderOne: {
                        font: 'Roboto',
                        bold: true,
                        fontSize: 14,
                        color: '#575962',
                        fillColor: 'white',
                        margin: [15, 15, 0, 15],
                        verticalAlign: 'center'
                    },
                    tableHeaderTwo: {
                        font: 'Roboto',
                        bold: true,
                        fontSize: 12,
                        color: '#575962',
                        fillColor: 'white',
                        margin: [0, 18, 0, 0],
                        verticalAlign: 'center'
                    },
                    tableHeaderIcon: {
                        fillColor: 'white',
                        margin: [15, 15, 0, 15],
                        verticalAlign: 'center'
                    },
                    smallText: {
                        bold: false, fontSize: 9, color: '#afb2c1'
                    },
                    tableFields: {
                        bold: true,
                        fontSize: 11,
                        color: '#575962',
                        fillColor: 'white',
                        width: 'auto',
                        margin: [0, 15, 0, 10]
                    }
                },
                'default': {
                    font: 'Poppins',
                    color: '#3f4047',
                    fontSize: 9
                },
                'tableLayout': {
                    fillColor: function fillColor(i, node) {
                        return i % 2 !== 0 || i === 0 ? '#ffffff' : '#f4f5f8'
                    },
                    hLineColor: function hLineColor(i, node) {
                        return '#ebedf2'
                    },
                    defaultBorder: false
                },
                'topBorderOnly': [false, true, false, false],
                'noBorder': [false, false, false, false]
            }
        },
        pdfContent() {
            return {
                'propertyOverview': {
                    text: 'Property Overview',
                    style: 'header' },
                'address': {
                    text: this.property.address,
                    style: 'subheader'
                },
                'logo': {
                    image: this.base64Images().logo,
                    link: window.location.href,
                    width: 100
                },
                table: (noOfColumns) => {
                    const widths = [60]
                    for (let i = 0; i < noOfColumns - 1; i++) {
                        widths.push('auto')
                    }
                    const table = {
                        style: 'table',
                        layout: this.pdfStyles().tableLayout,
                        table: {
                            widths: widths,
                            heights: 15,
                            headerRows: 1,
                            body: []
                        },
                        pageBreak: 'before'
                    }
                    return table
                },
                tableHeader: (headerName, dataSource, noOfColumns) => {
                    const nestedHeader = {
                        table: {
                            widths: ['auto', '*'],
                            body: [
                                [this.pdfContent().statisticsIcon,
                                { text: [{ text: headerName + ' '}, { text: ' ' + dataSource, style: 'smallText'}],
                                style: 'tableHeaderTwo', border: this.pdfStyles().noBorder, noWrap: true }]
                            ]
                        }
                    }

                    const header = [nestedHeader]
                    for (let i = 0; i < noOfColumns - 1; i++) {
                        header.push({})
                    }
                    return header
                },
                tableFields: (fieldNames) => {
                    const fields = []
                    fieldNames.forEach((field) => {
                        fields.push({ 
                            text: field.text, 
                            /*style: 'tableFields',*/ 
                            bold: true,
                            fontSize: 9,
                            color: '#575962',
                            fillColor: 'white',
                            border: this.pdfStyles().topBorderOnly
                        })
                    })
                    return fields
                },
                'statisticsIcon': {
                    image: this.base64Images().flaticon,
                    width: 20,
                    style: 'tableHeaderIcon',
                    colSpan: 1,
                    border: [false, false, false, false]
                }
            }
        },
        base64Images() {
            return {
                'flaticon': 'data:image/png;base64,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',
                'logo': 'data:image/png;base64,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'
            }
        },
        generalTable() {
            const header = [{ text: 'General', style: 'tableHeaderOne', colSpan: 10, border: [false, false, false, true] }, {}, {}, {}, {}, {}, {}, {}, {}, {}]
            const fields = [
                { text: 'Owner', style: 'tableFields' },
                { text: 'Year Built', style: 'tableFields' },
                { text: 'Tax Block', style: 'tableFields' },
                { text: 'Tax Lot', style: 'tableFields' },
                { text: 'Number of Buildings', style: 'tableFields' },
                { text: 'Number of Floors', style: 'tableFields' },
                { text: 'Number of Units', style: 'tableFields' },
                { text: 'Lot Area', style: 'tableFields' },
                { text: 'Gross Floor Area', style: 'tableFields' },
                { text: 'Landmark', style: 'tableFields' }
            ]
            const row = [
                this.zone.pluto.OwnerName,
                this.zone.pluto.YearBuilt,
                this.zone.pluto.Block,
                this.zone.pluto.Lot,
                this.zone.pluto.NumBldgs,
                this.zone.pluto.NumFloors,
                this.zone.pluto.UnitsTotal,
                this.zone.pluto.LotArea,
                this.zone.pluto.BldgArea,
                this.zone.pluto.Landmark
            ]
            const table = {
                style: 'table',
                layout: {
                    fillColor: '#ffffff',
                    hLineColor: function hLineColor(i, node) {
                        return '#ebedf2'
                    },
                    defaultBorder: false
                },
                table: {
                    widths: '*',
                    heights: 40,
                    headerRows: 2,
                    body: [header, fields, row]
                }
            }
            return table
        },
        jobApplicationsOpenDataTable(data) {

            const headerName = 'Job Applications'
            const fieldNames = [
                {text: 'Job #', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Doc #', width: 'auto', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'File Date', width: 'auto', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Job Type', width: 'auto', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Status Date', width: 'auto', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Status Code', width: 'auto', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Job Status', width: 'auto', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Applicant', width: 'auto', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'License #', width: 'auto', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Work On Floors', width: 'auto', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Description', width: 'auto', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly}
            ]
            const dataSource = '(Open Data)'
            const noOfColumns = 11

            const header = this.pdfContent().tableHeader(headerName, dataSource, noOfColumns)
            const fields = this.pdfContent().tableFields(fieldNames)
            const content = this.pdfContent().table(noOfColumns)
            content.table.body = []
            content.table.body.push(header, fields)
            data.filter((item) => {
                if(item.job_application_ext.job_description != null && !item.job_application_ext.job_description.includes('WITHDRAWN') && !item.job_application_ext.job_description.includes('ADMIN CLOSED')){ 
                    content.table.body.push([
                        item.job__, 
                        item.doc__, 
                        item.pre_filing_date, 
                        item.job_type, 
                        this.formatDate(item.latest_action_date), 
                        item.job_status, 
                        item.job_status_descrp, 
                        item.applicant_s_first_name+' '+item.applicant_s_last_name, 
                        item.applicant_license__, 
                        item.job_application_ext.total_construction_floor_area, 
                        item.job_application_ext.job_description
                    ])
                }
            })
            console.log(content.table)
            return content
        },
        zoningTable() {
            const header = [{ text: 'Zoning', style: 'tableHeaderOne', colSpan: 9, border: [false, false, false, true] }, {}, {}, {}, {}, {}, {}, {}, {}]
            const fields = [
                { text: 'Zoning District 1', style: 'tableFields' },
                { text: 'Zoning District 2', style: 'tableFields' },
                { text: 'Commercial Overlay 1', style: 'tableFields' },
                { text: 'Commercial Overlay 2', style: 'tableFields' },
                { text: 'Land Use', style: 'tableFields' },
                { text: 'Built FAR', style: 'tableFields' },
                { text: 'Commercial FAR', style: 'tableFields' },
                { text: 'Residential FAR', style: 'tableFields' },
                { text: 'Facility FAR', style: 'tableFields' }
            ]
            const row = [
                this.zone.pluto.ZoneDist1,
                this.zone.pluto.ZoneDist2,
                this.zone.pluto.Overlay1,
                this.zone.pluto.Overlay2,
                this.zone.pluto.LandUse,
                this.zone.pluto.BuiltFAR,
                this.zone.pluto.CommFAR,
                this.zone.pluto.ResidFAR,
                this.zone.pluto.FacilFAR
            ]
            const table = {
                style: 'table',
                layout: {
                    fillColor: '#ffffff',
                    hLineColor: function hLineColor(i, node) {
                        return '#ebedf2'
                    },
                    defaultBorder: false
                },
                table: {

                    widths: '*',
                    heights: 40,
                    headerRows: 2,
                    body: [header, fields, row]
                }
            }
            return table
        },
        tooComplaintsTable(data) {
            const headerName = '311 Complaints'
            const fieldNames = ['Agency', 'Status', 'Issue Date', 'Description']
            const dataSource = '(Open Data)'
            const noOfColumns = 4

            const header = this.pdfContent().tableHeader(headerName, dataSource, noOfColumns)
            const fields = this.pdfContent().tableFields(fieldNames)
            const content = this.pdfContent().table(noOfColumns)
            content.table.body.push(header, fields)
            data.filter((item) => {
                content.table.body.push([item.agency_name, item.status, item.created_date, item.resolution_description])
            })
            return content
        },
        complaintsBisTable(data) {
            const headerName = 'Complaints'
            const fieldNames = [
                {text: 'Complaint #', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Issue Date', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Category', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Disposition', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Description', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Comments', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Status', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
            ]
            const dataSource = '(BIS)'
            const noOfColumns = 7

            const header = this.pdfContent().tableHeader(headerName, dataSource, noOfColumns)
            const fields = this.pdfContent().tableFields(fieldNames)
            const content = this.pdfContent().table(noOfColumns)
            content.table.body.push(header, fields)
            data.filter((item) => {
                content.table.body.push([ 
                    item.complaint_number, 
                    item.date_entered,
                    item.category_code+' '+item.category_code_description, 
                    item.disposition, 
                    item.description, 
                    item.comments, 
                    item.status
                ])
            })
            return content
        },
        dobViolationsOpenDataTable(data) {
            const headerName = 'DOB Violations'
            const fieldNames = [ 
                {text: 'DOB Violation #', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Issue Date', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Type', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Diposition Date', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Disposition Comments', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Device #', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Description', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Status', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
            ]
            const dataSource = '(Open Data)'
            const noOfColumns = 8

            const header = this.pdfContent().tableHeader(headerName, dataSource, noOfColumns)
            const fields = this.pdfContent().tableFields(fieldNames)
            const content = this.pdfContent().table(noOfColumns)
            content.table.body.push(header, fields)
            data.filter((item) => {
                content.table.body.push([
                    item.violation_number,
                    item.issue_date, 
                    item.violation_type, 
                    item.disposition_date, 
                    item.disposition_comments, 
                    item.device_number, 
                    item.description, 
                    item.violation_category
                ])
            })
            return content
        },
        dobViolationsBisTable(data) {
            const headerName = 'DOB Violations'
            const fieldNames = [
                {text: 'DOB Violation #', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Issue Date', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Type', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Diposition Date', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Disposition Comments', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Device #', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Description', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Status', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
            ]
            const dataSource = '(BIS)'
            const noOfColumns = 8

            const header = this.pdfContent().tableHeader(headerName, dataSource, noOfColumns)
            const fields = this.pdfContent().tableFields(fieldNames)
            const content = this.pdfContent().table(noOfColumns)
            content.table.body.push(header, fields)
            data.filter((item) => {
                content.table.body.push([
                    item.dob_violation_number,
                    item.issue_date, 
                    item.violation_type, 
                    item.disposition_date, 
                    item.disposition_comments, 
                    item.device_number, 
                    item.description, 
                    item.status
                ])
            })
            return content
        },
        ecbViolationsOpenDataTable(data) {
            const app = this;
            const headerName = 'ECB Violations'
            const fieldNames = [
                {text: 'ECB Violation #', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Issue Date', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Respondent', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Hearing Date / Time', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Hearing Status', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Certification Status', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Description', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Status', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
            ]
            const dataSource = '(Open Data)'
            const noOfColumns = 8

            const header = this.pdfContent().tableHeader(headerName, dataSource, noOfColumns)
            const fields = this.pdfContent().tableFields(fieldNames)
            const content = this.pdfContent().table(noOfColumns)
            content.table.body.push(header, fields)
            data.filter((item) => {
                content.table.body.push([
                    item.ecb_violation_number, 
                    app.formatDate(item.issue_date), 
                    item.respondent_name, 
                    app.formatDate(item.hearing_date)+' - '+ item.hearing_time, 
                    item.hearing_status, 
                    item.certification_status,
                    item.violation_description, 
                    item.ecb_violation_status
                ])
            })
            return content
        },
        ecbViolationsBisTable(data) {
            const headerName = 'ECB Violations'
            const fieldNames = [
                {text: 'ECB Violation #', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Issue Date', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Respondent', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Hearing Date/Time', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Certification Status', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Description', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Specific Conditions', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'DOB Violation Status', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
            ]
            const dataSource = '(BIS)'
            const noOfColumns = 8

            const header = this.pdfContent().tableHeader(headerName, dataSource, noOfColumns)
            const fields = this.pdfContent().tableFields(fieldNames)
            const content = this.pdfContent().table(noOfColumns)
            content.table.body.push(header, fields)
            data.filter((item) => {
                content.table.body.push([
                    item.ecb_violation_number, 
                    item.violation_date, 
                    item.respondent, 
                    item.scheduled_hearing_date, 
                    item.certification_status, 
                    item.standard_description, 
                    item.specific_violation_conditions, 
                    item.buildings_violation_status+' '+item.buildings_violation_status_msg
                ])
            })
            return content
        },
        jobApplicationsBisTable(data) {
            const headerName = 'Job Applications'
            const fieldNames = [
                {text: 'Job #', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Latest Action Date', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Type', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Status', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Description', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Applicant', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
            ]
            const dataSource = '(BIS)'
            const noOfColumns = 6

            const header = this.pdfContent().tableHeader(headerName, dataSource, noOfColumns)
            const fields = this.pdfContent().tableFields(fieldNames)
            const content = this.pdfContent().table(noOfColumns)
            content.table.body = []
            content.table.body.push(header, fields)
            data.filter((item) => {
                if(item.job_description != null && !item.job_description.includes('WITHDRAWN') && !item.job_description.includes('ADMIN CLOSED')){ 
                    content.table.body.push([
                        item.job_number, 
                        item.status_date, 
                        item.job_type, 
                        item.job_status, 
                        item.job_description, 
                        item.applicant.name
                    ])
                }
            })
            return content
        },
        jobApplicationsOpenDataTable(data) {
            const headerName = 'Job Applications'
            const fieldNames = [
                {text: 'Job #', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Latest Action Date', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Type', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Status', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
                {text: 'Applicant', width: '10', bold: true, fontSize: 9, color: '#575962', fillColor: 'white', border: this.pdfStyles().topBorderOnly},
            ]
            const dataSource = '(Open Data)'
            const noOfColumns = 5

            const header = this.pdfContent().tableHeader(headerName, dataSource, noOfColumns)
            const fields = this.pdfContent().tableFields(fieldNames)
            const content = this.pdfContent().table(noOfColumns)
            content.table.body.push(header, fields)
            data.filter((item) => {
                content.table.body.push([
                    item.job__, 
                    item.latest_action_date, 
                    item.job_type, 
                    item.job_status,
                    item.applicant_s_first_name+' '+item.applicant_s_last_name
                ])
            })
            return content
        }
    }
}
</script>
<style scoped>
    .fa fa-spinner fa-spin fa-7x {
        font-size: 1.5em;
    }

    [class^="fa-"], [class*=" fa-"] {
        margin-right: 7px;
    }

    #fa_mobile_pdf {
        margin-right: 0 !important;
    }

    #mobile_button_pdf {
        margin-left: 10px;
    }

    .btn-info.disabled, .btn-info:disabled {
        cursor: default;
        background-color: #36a3f7; 
    }

    .btn-info:disabled:focus, .btn-info:disabled:hover {
        background: linear-gradient(180deg, #54b1f8, #36a3f7) repeat-x;
        border-color: #36a3f7;
    }
</style>
