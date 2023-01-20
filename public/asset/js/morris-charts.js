var MorrisChartsDemo = {
    init: function () {
        new Morris.Line({
            element: "m_morris_1",
            data: [
                { y: "2006", a: 100, b: 90 },
                { y: "2007", a: 75, b: 65 },
                { y: "2008", a: 50, b: 40 },
                { y: "2009", a: 75, b: 65 },
                { y: "2010", a: 50, b: 40 },
                { y: "2011", a: 75, b: 65 },
                { y: "2012", a: 100, b: 90 },
            ],
            xkey: "y",
            ykeys: ["a", "b"],
            labels: ["Values A", "Values B"],
        }),
            new Morris.Area({
                element: "m_morris_2",
                data: [
                    { y: "2006", a: 100, b: 90 },
                    { y: "2007", a: 75, b: 65 },
                    { y: "2008", a: 50, b: 40 },
                    { y: "2009", a: 75, b: 65 },
                    { y: "2010", a: 50, b: 40 },
                    { y: "2011", a: 75, b: 65 },
                    { y: "2012", a: 100, b: 90 },
                ],
                xkey: "y",
                ykeys: ["a", "b"],
                labels: ["Series A", "Series B"],
            }),
            new Morris.Bar({
                element: "m_morris_3",
                data: [
                    { y: "2006", a: 100, b: 90 },
                    { y: "2007", a: 75, b: 65 },
                    { y: "2008", a: 50, b: 40 },
                    { y: "2009", a: 75, b: 65 },
                    { y: "2010", a: 50, b: 40 },
                    { y: "2011", a: 75, b: 65 },
                    { y: "2012", a: 100, b: 90 },
                ],
                xkey: "y",
                ykeys: ["a", "b"],
                labels: ["Series A", "Series B"],
            }),
            new Morris.Donut({
                element: "m_morris_4",
                data: [
                    { label: "Download Sales", value: 12 },
                    { label: "In-Store Sales", value: 30 },
                    { label: "Mail-Order Sales", value: 20 },
                ],
            });
    },
};
jQuery(document).ready(function () {
    MorrisChartsDemo.init();
});
