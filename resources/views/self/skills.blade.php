@verbatim
<section id="skills">
  <div class="wrap">
    <div class="sec-head">
      <span class="sec-badge"><span class="sec-badge-dot"></span> {{ t.skillBadge }}</span>
      <h2>{{ t.skillSection }}</h2>
      <p>{{ t.skillSectionSub }}</p>
    </div>
    <div class="grid2">
      <div class="skillset">
        <div class="skillrow reveal from-up" v-for="s in t.skills" :key="s.k">
          <div class="k">{{ s.k }}</div>
          <div class="v"><span class="sk" v-for="i in s.items" :key="i">{{ i }}</span></div>
        </div>
      </div>
      <div class="edu reveal from-right">
        <h3>{{ t.eduDegree }}</h3>
        <div class="uni">Telkom University</div>
        <div class="gpa">GPA 3.87 / 4.00 · 2015–2019</div>
        <div class="paper">{{ t.eduPaper }}</div>
      </div>
    </div>
  </div>
</section>
@endverbatim

<script>
Object.assign(I18N.en, {
  skillBadge:"Competencies",
  skillSection:"Skills & Education",
  skillSectionSub:"Technical stack, architecture paradigms, and academic background in computational science.",
  skills:[
    {k:"Languages & Frameworks",items:["PHP (Laravel)","JavaScript","TypeScript","Vue.js","React","Node.js"]},
    {k:"Frontend",items:["Inertia.js","Tailwind CSS","HTML","jQuery"]},
    {k:"Backend & APIs",items:["RESTful API","MVC","Performance tuning"]},
    {k:"Data & Infra",items:["SQL Server","MySQL","Redis","Docker","Git","Linux"]},
  ],
  eduDegree:"S.Si.Kom. in Computational Science",
  eduPaper:"Final project: stock portfolio optimization using Polynomial Goal Programming (PGP), published in the Indonesian Journal on Computing (IndoJC), 2019.",
});
Object.assign(I18N.id, {
  skillBadge:"Kompetensi",
  skillSection:"Keahlian & Pendidikan",
  skillSectionSub:"Keahlian teknologi, arsitektur sistem, dan fondasi akademik di bidang ilmu komputasi.",
  skills:[
    {k:"Bahasa & Framework",items:["PHP (Laravel)","JavaScript","TypeScript","Vue.js","React","Node.js"]},
    {k:"Frontend",items:["Inertia.js","Tailwind CSS","HTML","jQuery"]},
    {k:"Backend & API",items:["RESTful API","MVC","Optimasi performa"]},
    {k:"Data & Infra",items:["SQL Server","MySQL","Redis","Docker","Git","Linux"]},
  ],
  eduDegree:"S.Si.Kom. Ilmu Komputasi",
  eduPaper:"Tugas akhir: optimasi portofolio saham dengan Polynomial Goal Programming (PGP), dipublikasikan di Indonesian Journal on Computing (IndoJC), 2019.",
});
</script>
