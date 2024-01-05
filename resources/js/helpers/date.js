import dayjs from "dayjs";
import utc from "dayjs/plugin/utc";
import tz from "dayjs/plugin/timezone";
import updateLocale from "dayjs/plugin/updateLocale";

dayjs.extend(utc);
dayjs.extend(tz);
dayjs.extend(updateLocale);

dayjs.updateLocale("en", {
    months: [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember",
    ],
});

export const formatDate = (date) =>
    date ? dayjs.tz(date, "Asia/Jakarta").format("DD MMMM YYYY") : "-";
