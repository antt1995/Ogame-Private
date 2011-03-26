// ������ ������ ���������� ���� OGame.

/*
������� ���

������� ��� ������ ���������� � ��� �������, ����� ��������� ����� ����������� � �����-���� ������� ��� ����.
��� ��������� � �������� ��� ���������, �� � ��� ����� ��������, ��� ������� ���� ��� ���������.
� ���� ������ ������ ������� ������������� � �������� ������ ���� �� �����. ��� ���������� 6 ��� (6 �������).
��� � ����� ������� � ���������, ��� ����������. ���� � ����� �� ����� �������� �������� �����, �� ��� ������������� ������ � ���������� ������������ �����.
� ������ ������ ������� � �������� ���������� �������� ���� �� �����. ��� ���� ������ ���� �������� ���� ��� (����������: ����������) �� �������� ��������� ����.
������� ���� �������� ������������ ������� �����. ��� ���� ����������� �������� ��� ��������� ������. ���� ����� ����� ��� ���-�� ������� �� ������ ����, �� ��� ���������� �� ����� �������.
�������� ����� �������� ���� �� �������� � ��������� ������������ ������. � ����� ������ ���������� �������, � ������� ������ �� �������� �����.
�� � �� 30% ����������� ����� ���� ������� ���� ������, ������� ����� ������ �� �������� �����������.
���� ��������:
������ ���� ����� ��������� ���� ��������. Ÿ ����� ��������� ������������� ��������� ������� �� 10% �� �������.
��������: ������ ����������� ����� ������ ����� 150. ��������� ������� ������ 10 �������� ��� �� 100% �� ���� �� 300.
��� ��� ������ ���� ���� ������ ������������ ������.
����:
���� ������� ��������� ���� �� ����, ����������� ����� �� �����������. ������ ����� ��� ���� ����������, ���������� ����������� �����.
���� ����� ���� �������� ������������� ������� ���������� �� 10% �� ������� ������������.
���� ��������� ����������������� ����� ������� ������. ������ ������ ��� ������������ ������ �������� �� 1%, � ������� ���� ����� ����� 1% ����������� ��� �����-���� ������.
��������, ���� ���� �������� ������� �� 3.7% ����, ����� ���������� ���� 3%, � 0.7% ����������. ������� �������� � ����� ����� 1%, ����������� �� �����, �� �������� �� ���� � �� ������ ����� �����.
����������� ������ � ���� ������ ����� �� �������������.
������: ����� ����������� (����� 50) �������� �� �������� ������ (��� 10000). ����� �������� � ������ �� ��� 10000 �����, ��� ��� ������� ������� ���� � ��� ��� ��������� ���������.
������ �� ����������� ����� ���� �������� 150. ��� 1.5% �� ����, ������� ������� ������������� � �� ���� ��������� ����� ����� ����� - 1%.
����� ����� � ������ ������� ���� ����� ������ 9900, ��� ��� 0.5% = 50 ����� ��������� ����� ��� ������.
�����:
����� ���������, ����� ����� ������� ����� ���������, ������ ��� �� ����� ���������. ����� ����� ������ ���������� 10% ���������.
�� ����� ��������� ��� ��� ��������� �����. �� ������ 10 ������� ��� ��������� (���� ����� �� ���������) ���������� 1 ����� �����.
���� ����� ����� ������������� ������������� ����� ����������� �������� �� 10% �� �������. � ���������, ������� ������� � ��������� ��� �� 30% ����������� �����.
����� ��� ������������ ������ ������. ������������ ����������: ���� ����� ����������� ���� ���������� � ������ 2-� �������.
����� ���������� �������� ������ �������� ���������. �������� �������� ������ ������
������� ���������
���� ������� ��������� ����� ��������, � ������ ����� ������� � ������ ������� �� ��������: ����� �������, ������ �������, ����� ������, ������ ������.
����� ����
���� ���������� ��������� ��������. ����� ����, ��� ��� ����� ����� �� ����� ����, ���� ���� � ������ ����, �� ��� ������������.
������ ������ ���� ���, ��� �����, ������� ������ �����, �������� ������ ���� ���������. ��� ���� � ������� ������� � ��������� ���������� ���� �����������, ��� � ���� �������, ������ 1/(���-�� ���� ������)
�������������� ������:
�������� ���������� ����� ����������� �� �������������� ����� ��� � 70%.
��� ��������� ���������� ������ (������ ��� 10) ��� ����������� ������������� ��� ������� ���������� ��������.
��� ������� ���������� ����������� ������������� ��� ������� ���� ������. ��� ���� ����������������� ������ 70% +/-10% ����������� ������.
��� 10 �������� ���������� ��� ������� 6 � �������� 8 ��������������� ��. ������� ����� ��������� �����������. ��� ������� ���� ������ ����������� ������������� ��������.
�� ����, ��������, �� � ������ �� ������������ ������. 

����������              
������ ���������� �������� ����������� ��������� ����� �������� ����������� �� ����� ����� ������������ �������� ��� ������ ��������. 
����������� ���������� �������� ���������� � ������� �� ����� ����������� ������� � ���� ��������. ������ ����������� ����������� � �������������� ����������� ���������� �������� ��� - ��� � ���� - ������� ����������� ��������� �� ���� �����.
� ������� ���������� �������� ��������� �������:
�������, ������� �� �����, ������ �������� � ���� ���� ����������, � ����������� ������������ �������� ��� ���, � ������������ � �������� ��� - �� ��������� ������� ����.
��� ��������� ��������� � ����� ������ �������, ����� "��������� ������" � ���� ������, ���������� ��� ���� �������. 
<�������� � ���������� ������� �������� ����������� �� http://board.ogame.ru/index.php?page=Thread&threadID=47130 >
*/

/*
���������� ������.

������ ������������ ����� ������ ����. �� ���� �������� ��������� ������� (���������� �� ���� ������):
- ������ ��������� � ������������� 
- ���������� �������, ��������� � �������� �� �������
- ��������� ������ ������� (������� ������� � ����� � �������, ����������)

�� ������ ������ ����������:
- ���������� ��� (������������ � ���� ������)
- HTML-��� ������� ������� (��������� � stdout)
*/

// ��� ���� ����� ������ �������� ��������� � ���� ���� (��� �������� ������), ��������� ����� ���������� �� 100 (������ 202), � ������� �� 200 (������ 401).

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>
#include <math.h>
#include <windows.h>
#include <mysql.h>
#include "battle.h"

// ��������� ��������� ����.
int DefenseInDebris = 0, FleetInDebris = 30;
int Rapidfire = 1;  // 1: ��� �������� ���������.

// ������� ���������.
typedef struct UnitPrice { long m, k, d; } UnitPrice;
static UnitPrice FleetPrice[] = {
 { 2000, 2000, 0 }, { 6000, 6000, 0 }, { 3000, 1000, 0 }, { 6000, 4000, 0 },
 { 20000, 7000, 2000 }, { 45000, 15000, 0 }, { 10000, 20000, 10000 }, { 10000, 6000, 2000 },
 { 0, 1000, 0 }, { 50000, 25000, 15000 }, { 0, 2000, 500 }, { 60000, 50000, 15000 },
 { 5000000, 4000000, 1000000 }, { 30000, 40000, 15000 }
};
static UnitPrice DefensePrice[] = {
 { 2000, 0, 0 }, { 1500, 500, 0 }, { 6000, 2000, 0 }, { 20000, 15000, 2000 },
 { 2000, 6000, 0 }, { 50000, 50000, 30000 }, { 10000, 10000, 0 }, { 50000, 50000, 0 }
};

TechParam fleetParam[14] = { // ��� �����.
 { 4000, 10, 5, 5000 },
 { 12000, 25, 5, 25000 },
 { 4000, 10, 50, 50 },
 { 10000, 25, 150, 100 },
 { 27000, 50, 400, 800 },
 { 60000, 200, 1000, 1500 },
 { 30000, 100, 50, 7500 },
 { 16000, 10, 1, 20000 },      
 { 1000, 0, 0, 0 },
 { 75000, 500, 1000, 500 },
 { 2000, 1, 1, 0 },
 { 110000, 500, 2000, 2000 }, 
 { 9000000, 50000, 200000, 1000000 }, 
 { 70000, 400, 700, 750 }
};

TechParam defenseParam[8] = { // ��� �������.
 { 2000, 20, 80, 0 },
 { 2000, 25, 100, 0 },
 { 8000, 100, 250, 0 },
 { 35000, 200, 1100, 0 },
 { 8000, 500, 150, 0 },
 { 100000, 300, 3000, 0 },
 { 20000, 2000, 1, 0 },
 { 100000, 10000, 1, 0 },
};

// ��������� �����������.
static long FleetRapid[][14] = {
 { 0, 0, 0, 0, 0, 0, 0, 0, 800, 0, 800, 0, 0, 0 },
 { 0, 0, 0, 0, 0, 0, 0, 0, 800, 0, 800, 0, 0, 0 },
 { 0, 0, 0, 0, 0, 0, 0, 0, 800, 0, 800, 0, 0, 0 },
 { 667, 0, 0, 0, 0, 0, 0, 0, 800, 0, 800, 0, 0, 0 },
 { 0, 0, 833, 0, 0, 0, 0, 0, 800, 0, 800, 0, 0, 0 },
 { 0, 0, 0, 0, 0, 0, 0, 0, 800, 0, 800, 0, 0, 0 },
 { 0, 0, 0, 0, 0, 0, 0, 0, 800, 0, 800, 0, 0, 0 },
 { 0, 0, 0, 0, 0, 0, 0, 0, 800, 0, 800, 0, 0, 0 },
 { 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 },
 { 0, 0, 0, 0, 0, 0, 0, 0, 800, 0, 800, 0, 0, 0 },
 { 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 },
 { 0, 0, 0, 0, 0, 0, 0, 0, 800, 0, 800, 0, 0, 500 },
 { 996, 996, 995, 990, 970, 966, 996, 996, 999, 960, 999, 800, 0, 933 },
 { 667, 667, 0, 750, 750, 857, 0, 0, 800, 0, 800, 0, 0, 0 }
};
static long DefenseRapid[][8] = {
 { 0, 0, 0, 0, 0, 0, 0, 0 },
 { 0, 0, 0, 0, 0, 0, 0, 0 },
 { 0, 0, 0, 0, 0, 0, 0, 0 },
 { 0, 0, 0, 0, 0, 0, 0, 0 },
 { 900, 0, 0, 0, 0, 0, 0, 0 },
 { 0, 0, 0, 0, 0, 0, 0, 0 },
 { 0, 0, 0, 0, 0, 0, 0, 0 },
 { 0, 0, 0, 0, 0, 0, 0, 0 },
 { 0, 0, 0, 0, 0, 0, 0, 0 },
 { 955, 955, 900, 0, 900, 0, 0, 0 },
 { 0, 0, 0, 0, 0, 0, 0, 0 },
 { 0, 900, 0, 0, 0, 0, 0, 0 },
 { 955, 955, 999, 980, 999, 0, 0, 0 },
 { 0, 0, 0, 0, 0, 0, 0, 0 }
};

// ==========================================================================================
// ��������� ��������� �����.
// Mersenne Twister.

#define N 624
#define M 397
#define MATRIX_A 0x9908b0dfUL
#define UPPER_MASK 0x80000000UL
#define LOWER_MASK 0x7fffffffUL

static unsigned long mt[N];
static int mti=N+1;

void init_genrand(unsigned long s)
{
    mt[0]= s & 0xffffffffUL;
    for (mti=1; mti<N; mti++) {
        mt[mti] = 
	    (1812433253UL * (mt[mti-1] ^ (mt[mti-1] >> 30)) + mti); 
        mt[mti] &= 0xffffffffUL;
    }
}

unsigned long genrand_int32(void)
{
    unsigned long y;
    static unsigned long mag01[2]={0x0UL, MATRIX_A};

    if (mti >= N) {
        int kk;

        if (mti == N+1)
            init_genrand(5489UL);

        for (kk=0;kk<N-M;kk++) {
            y = (mt[kk]&UPPER_MASK)|(mt[kk+1]&LOWER_MASK);
            mt[kk] = mt[kk+M] ^ (y >> 1) ^ mag01[y & 0x1UL];
        }
        for (;kk<N-1;kk++) {
            y = (mt[kk]&UPPER_MASK)|(mt[kk+1]&LOWER_MASK);
            mt[kk] = mt[kk+(M-N)] ^ (y >> 1) ^ mag01[y & 0x1UL];
        }
        y = (mt[N-1]&UPPER_MASK)|(mt[0]&LOWER_MASK);
        mt[N-1] = mt[M-1] ^ (y >> 1) ^ mag01[y & 0x1UL];

        mti = 0;
    }
  
    y = mt[mti++];

    y ^= (y >> 11);
    y ^= (y << 7) & 0x9d2c5680UL;
    y ^= (y << 15) & 0xefc60000UL;
    y ^= (y >> 18);

    return y;
}

double genrand_real1(void) { return genrand_int32()*(1.0/4294967295.0); }
double genrand_real2(void) { return genrand_int32()*(1.0/4294967296.0); }

// ������������ ��������������� ������������������.
void MySrand (unsigned long seed)
{
    init_genrand (seed);
    //srand (seed);
}

// ���������� ��������� ����� � ��������� �� a �� b (������� a � b)
unsigned long MyRand (unsigned long a, unsigned long b)
{
    return a + (unsigned long)(genrand_real1 () * (b - a + 1));
    //return a + (unsigned long)((rand ()*(1.0/RAND_MAX)) * (b - a + 1));
}

// ==========================================================================================

// ���������� � ��������������� �������.
unsigned long ExplodedDefense[8], ExplodedDefenseTotal;
unsigned long RepairDefense[8], RepairDefenseTotal;

// �������������� ����� �� �������. ������� �������� :)
// ������� �������� non-reentrant. ��� �������� ��� � ������ ������������ ��������� ��� � ����� ���������, 
// ������ ��� ��� ������ ���������� ����������� �����, ������� ��� �������� ����� �����������.
// ��� ����� ����� ���������� ��������� ������ �� ��������� ������.
static char *nicenum (u64 n)
{
	static char retbuf [32];
	char *p = &retbuf [sizeof (retbuf) - 1];
	int i = 0;

    if (n == 0) return "0";
	*p = '\0';
	for (i = 0; n; i++)
	{
		if (((i % 3) == 0) && (i != 0))
			*--p = '.';
		*--p = '0' + n % 10;
		n /= 10;
	}
	return p;
}

// ���������� ��������� ��������� ����.
void SetDebrisOptions (int did, int fid)
{
    if (did < 0) did = 0;
    if (fid < 0) fid = 0;
    if (did > 100) did = 100;
    if (fid > 100) fid = 100;
    DefenseInDebris = did;
    FleetInDebris = fid;
}

void SetRapidfire (int enable) { Rapidfire = enable & 1; }

// �������� ������ ��� ������ � ���������� ��������� ��������.
Unit *InitBattleAttackers (Slot *a, int anum, int objs)
{
    Unit *u;
    int aid = 0;
    int i, n, ucnt = 0, obj;
    u = (Unit *)malloc (objs * sizeof(Unit));
    if (u == NULL) return u;
    memset (u, 0, objs * sizeof(Unit));
    
    for (i=0; i<anum; i++, aid++) {
        for (n=0; n<14; n++)
        {
            for (obj=0; obj<a[i].fleet[n]; obj++) {
                u[ucnt].hull = u[ucnt].hullmax = fleetParam[n].structure * 0.1 * (10+a[i].armor) / 10;
                u[ucnt].obj_type = 100 + n;
                u[ucnt].slot_id = aid;
                ucnt++;
            }
        }
    }

    return u;
}

Unit *InitBattleDefenders (Slot *d, int dnum, int objs)
{
    Unit *u;
    int did = 0;
    int i, n, ucnt = 0, obj;
    u = (Unit *)malloc (objs * sizeof(Unit));
    if (u == NULL) return u;
    memset (u, 0, objs * sizeof(Unit));

    for (i=0; i<dnum; i++, did++) {
        for (n=0; n<14; n++)
        {
            for (obj=0; obj<d[i].fleet[n]; obj++) {
                u[ucnt].hull = u[ucnt].hullmax = fleetParam[n].structure * 0.1 * (10+d[i].armor) / 10;
                u[ucnt].obj_type = 100 + n;
                u[ucnt].slot_id = did;
                ucnt++;
            }
        }
        for (n=0; n<8; n++)
        {
            for (obj=0; obj<d[i].def[n]; obj++) {
                u[ucnt].hull = u[ucnt].hullmax = defenseParam[n].structure * 0.1 * (10+d[i].armor) / 10;
                u[ucnt].obj_type = 200 + n;
                u[ucnt].slot_id = did;
                ucnt++;
            }
        }
    }

    return u;
}

// ������� a => b. ���������� ����. aweap - ������� ��������� ���������� ��� ����� "a".
// absorbed - ���������� ������������ ������ ����� (��� ����, ���� �������, �� ���� ��� ����� "b").
// loss - ���������� ������ (��������� ����� ������+��������).
long UnitShoot (Unit *a, int aweap, Unit *b, u64 *absorbed, u64 *loss, u64 *dm, u64 *dk )
{
    float prc, depleted;
    long apower, adelta = 0;
    if (a->obj_type < 200) apower = fleetParam[a->obj_type-100].attack * (10+aweap) / 10;
    else apower = defenseParam[a->obj_type-200].attack * (10+aweap) / 10;

    if (b->exploded) return apower; // ��� �������.
    if (b->shield == 0) {  // ����� ���.
        if (apower >= b->hull) b->hull = 0;
        else b->hull -= apower;
    }
    else { // �������� �� �����, � ���� ������� �����, �� � �� �����.
        prc = (float)b->shieldmax * 0.01;
        depleted = floor ((float)apower / prc);
        if (b->shield < (depleted * prc)) {
            *absorbed += (u64)b->shield;
            adelta = apower - b->shield;
            if (adelta >= b->hull) b->hull = 0;
            else b->hull -= adelta;
            b->shield = 0;
        }
        else {
            b->shield -= depleted * prc;
            *absorbed += (u64)apower;
        }
    }
    if (b->hull <= b->hullmax * 0.7 && b->shield == 0) {    // �������� � �������� ����.
        if (MyRand (0, 99) >= ((b->hull * 100) / b->hullmax) || b->hull == 0) {
            if (b->obj_type > 200) {
                *dm += (u64)(ceil(DefensePrice[b->obj_type-200].m * ((float)DefenseInDebris/100.0F)));
                *dk += (u64)(ceil(DefensePrice[b->obj_type-200].k * ((float)DefenseInDebris/100.0F)));
                *loss += (u64)(DefensePrice[b->obj_type-200].m + DefensePrice[b->obj_type-200].k);
                ExplodedDefense[b->obj_type-200]++;
                ExplodedDefenseTotal++;
            }
            else {
                *dm += (u64)(ceil(FleetPrice[b->obj_type-100].m * ((float)FleetInDebris/100.0F)));
                *dk += (u64)(ceil(FleetPrice[b->obj_type-100].k * ((float)FleetInDebris/100.0F)));
                *loss += (u64)(FleetPrice[b->obj_type-100].m + FleetPrice[b->obj_type-100].k);
            }
            b->exploded = 1;
        }
    }
    return apower;
}

// ��������� ���������� ������� � �������. ���������� ���������� ���������� ������.
int WipeExploded (Unit **slot, int amount)
{
    Unit *src = *slot, *tmp;
    int i, p = 0, exploded = 0;
    tmp = (Unit *)malloc (sizeof(Unit) * amount);
    for (i=0; i<amount; i++) {
        if (!src[i].exploded) tmp[p++] = src[i];
        else exploded++;
    }
    free (src);
    *slot = tmp;
    return exploded;
}

// ��������� ���������������� �����.
u64 CalcCargo (Unit *units, int amount)
{
    int i;
    u64 cargo = 0;
    for (i=0; i<amount; i++) {
        if (units[i].obj_type < 200) cargo += fleetParam[units[i].obj_type - 100].cargo;
    }
    return cargo;
}

// ������ ������.
void Plunder (u64 cargo, u64 m, u64 k, u64 d, u64 *mcap, u64 *kcap, u64 *dcap )
{
    u64 total, mc, kc, dc, half, bonus;
    m /=2; k/=2; d /= 2;
    total = m+k+d;
    
    mc = cargo / 3;
    if (m < mc) mc = m;
    cargo = cargo - mc;
    kc = cargo / 2;
    if (k < kc) kc = k;
    cargo = cargo - kc;
    dc = cargo;
    if (d < dc)
    {
        dc = d;
        cargo = cargo - dc;
        m = m - mc;
        half = cargo / 2;
        bonus = half;
        if (m < half) bonus = m;
        mc += bonus;
        cargo = cargo - bonus;
        k = k - kc;
        if (k < cargo) kc += k;
        else kc += cargo;
    }    
    
    *mcap = mc; *kcap = kc; *dcap = dc;
}

// ��������� ��� �� ������� �����. ���� �� � ������ ����� ����� �� ����������, �� ��� ������������� ������ ��������.
int CheckFastDraw (Unit *aunits, int aobjs, Unit *dunits, int dobjs)
{
    int i;
    for (i=0; i<aobjs; i++) {
        if (aunits[i].hull != aunits[i].hullmax) return 0;
    }
    for (i=0; i<dobjs; i++) {
        if (dunits[i].hull != dunits[i].hullmax) return 0;
    }
    return 1;
}

// ������������� HTML-��� �����.
// ���� techs = 1, �� �������� ���������� (� ������� ���������� ���������� �� ����).
static void GenSlot (Unit *units, int slot, int objnum, Slot *a, Slot *d, int attacker, int techs)
{
    char *SlotCaption[2] = { "Defender", "Attacker" };
    Slot *s = attacker ? a : d;
    Unit *u;
    Slot coll;
    int n, i;
    unsigned long sum = 0;

    memset (&coll, 0, sizeof(Slot));
    coll.weap = s[slot].weap;
    coll.shld = s[slot].shld;
    coll.armor = s[slot].armor;

    // ������� �� � ���� ����.
    if (techs) {
        for (i=0; i<14; i++) { coll.fleet[i] = s[slot].fleet[i]; sum += s[slot].fleet[i]; }
        for (i=0; i<8; i++) { coll.def[i] = s[slot].def[i]; sum += s[slot].def[i]; }
    }
    else {
        for (i=0; i<objnum; i++) {
            u = &units[i];
            if (u->slot_id == slot) {
                if (u->obj_type < 200) { coll.fleet[u->obj_type-100]++; sum++; }
                else { coll.def[u->obj_type-200]++; sum++; }
            }
        }
    }

    printf ("<th><br><center>%s %s (<a href=\"#\">[%i:%i:%i]</a>)<br>", SlotCaption[attacker], s[slot].name, s[slot].g, s[slot].s, s[slot].p);
    if (sum > 0) {
        if (techs) printf ("Вооружение: %i%% Щиты: %i%% Броня: %i%%", s[slot].weap*10, s[slot].shld*10, s[slot].armor*10 );
        printf ("<table border=1>");
        printf ("<tr><th>#3</th>");
        for (n=0; n<14; n++) {
            if (coll.fleet[n] > 0) printf ("<th>%s</th>", "FleetShort[n]");
        }
        for (n=0; n<8; n++) {
            if (coll.def[n] > 0) printf ("<th>%s</th>", "DefenseShort[n]");
        }
        printf ("</tr>");
        printf ("<tr><th>#4</th>");
        for (n=0; n<14; n++) {
            if (coll.fleet[n] > 0) printf ("<th>%s</th>", nicenum((u64)coll.fleet[n]));
        }
        for (n=0; n<8; n++) {
            if (coll.def[n] > 0) printf ("<th>%s</th>", nicenum((u64)coll.def[n]));
        }
        printf ("</tr>");
        printf ("<tr><th>#5</th>");
        for (n=0; n<14; n++) {
            if (coll.fleet[n] > 0) printf ("<th>%s</th>", nicenum((u64)(fleetParam[n].attack * (10+coll.weap) / 10)));
        }
        for (n=0; n<8; n++) {
            if (coll.def[n] > 0) printf ("<th>%s</th>", nicenum((u64)(defenseParam[n].attack * (10+coll.weap) / 10)));
        }
        printf ("</tr>");
        printf ("<tr><th>#6</th>");
        for (n=0; n<14; n++) {
            if (coll.fleet[n] > 0) printf ("<th>%s</th>", nicenum((u64)(fleetParam[n].shield * (10+coll.shld) / 10)));
        }
        for (n=0; n<8; n++) {
            if (coll.def[n] > 0) printf ("<th>%s</th>", nicenum((u64)(defenseParam[n].shield * (10+coll.shld) / 10)));
        }
        printf ("</tr>");
        printf ("<tr><th>#7</th>");
        for (n=0; n<14; n++) {
            if (coll.fleet[n] > 0) printf ("<th>%s</th>", nicenum((u64)(fleetParam[n].structure * (10+coll.armor) / 100)));
        }
        for (n=0; n<8; n++) {
            if (coll.def[n] > 0) printf ("<th>%s</th>", nicenum((u64)(defenseParam[n].structure * (10+coll.armor) / 100)));
        }
        printf ("</tr>");
        printf ("</table>");
    }
    else printf ("#8");
    printf ("</center></th>");
}

void DoBattle (Slot *a, int anum, Slot *d, int dnum, u64 met, u64 crys, u64 deut)
{
    char longstr1[32], longstr2[32], longstr3[32];  // ������ ��� non-reentrant ������� nicenum.

    long slot, i, n, aobjs = 0, dobjs = 0, idx, rounds, sum = 0;
    long apower, rapidfire, rapidchance, repairchance, fastdraw;
    Unit *aunits, *dunits, *unit;

    // ��� ������ ������������� ������� ������� ���� ������: ����� ������� ����� ��������� �� � ���� �������, � ����� ���������� �������.
    // ����� ���� ����������� ������� �� ������������ ������, ��� ������ ��������������� ������� ������������ ������� ������������ RepairMap.    
    unsigned long RepairMap[8] = { 0, 1, 2, 3, 4, 6, 5, 7 };

    u64         shoots[2], spower[2], absorbed[2]; // ����� ���������� �� ���������.    

    u64         aloss = 0, dloss = 0;       // ������ ���������� � ��������������
    u64         dm = 0, dk = 0;             // ���� ��������
    u64         cm, ck, cd;         // ��������� �������, ���������, ��������
    int         moonchance;         // ���� ����������� ����

    struct tm *ptm;
    time_t rawtime;

    time (&rawtime);
    ptm = gmtime (&rawtime);

    memset ( ExplodedDefense, 0, sizeof(ExplodedDefense) );
    memset ( RepairDefense, 0, sizeof(RepairDefense) );
    ExplodedDefenseTotal = RepairDefenseTotal = 0;

    printf ("#1 %02i-%02i %02i:%02i:%02i . #2<br>", ptm->tm_mon+1, ptm->tm_mday, ptm->tm_hour, ptm->tm_min, ptm->tm_sec);

    // ����� ����� ����.
    printf ("<table border=1 width=100%%><tr>");
    for (slot=0; slot<anum; slot++) {
        GenSlot (NULL, slot, 0, a, d, 1, 1);
    }
    printf ("</tr></table>");
    printf ("<table border=1 width=100%%><tr>");
    for (slot=0; slot<dnum; slot++) {
        GenSlot (NULL, slot, 0, a, d, 0, 1);
    }
    printf ("</tr></table>");

    // ��������� ����������� ������ �� ���.
    for (i=0; i<anum; i++) {
        for (n=0; n<14; n++) aobjs += a[i].fleet[n];
    }
    for (i=0; i<dnum; i++) {
        for (n=0; n<14; n++) dobjs += d[i].fleet[n];
        if (i == 0) {
            for (n=0; n<8; n++) dobjs += d[i].def[n];
        }
    }

    // ����������� ������ ������ ������.
    aunits = InitBattleAttackers (a, anum, aobjs);
    if (aunits == NULL) {
        return;
    }
    dunits = InitBattleDefenders (d, dnum, dobjs);
    if (dunits == NULL) {
        return;
    }

    for (rounds=0; rounds<6; rounds++)
    {
        if (aobjs == 0 || dobjs == 0) break;

        // �������� ����������.
        shoots[0] = shoots[1] = 0;
        spower[0] = spower[1] = 0;
        absorbed[0] = absorbed[1] = 0;

        // �������� ����.
        for (i=0; i<aobjs; i++) {
            if (aunits[i].exploded) aunits[i].shield = aunits[i].shieldmax = 0;
            else aunits[i].shield = aunits[i].shieldmax = fleetParam[aunits[i].obj_type-100].shield * (10+a[aunits[i].slot_id].shld) / 10;
        }
        for (i=0; i<dobjs; i++) {
            if (dunits[i].exploded) dunits[i].shield = dunits[i].shieldmax = 0;
            else {
                if (dunits[i].obj_type > 200) dunits[i].shield = dunits[i].shieldmax = defenseParam[dunits[i].obj_type-200].shield * (10+d[dunits[i].slot_id].shld) / 10;
                else dunits[i].shield = dunits[i].shieldmax = fleetParam[dunits[i].obj_type-100].shield * (10+d[dunits[i].slot_id].shld) / 10;
            }
        }

        // ���������� ��������.
        for (slot=0; slot<anum; slot++)     // ���������
        {
            for (i=0; i<aobjs; i++) {
                rapidfire = 1;
                unit = &aunits[i];
                if (unit->slot_id == slot) {
                    // �������.
                    while (rapidfire) {
                        idx = MyRand (0, dobjs-1);
                        apower = UnitShoot (unit, a[slot].weap, &dunits[idx], &absorbed[1], &dloss, &dm, &dk );
                        shoots[0]++;
                        spower[0] += apower;
                        if (unit->obj_type < 200) { // ������ ���� �������� ��������� ���������.
                            if (dunits[idx].obj_type < 200) rapidchance = FleetRapid[unit->obj_type-100][dunits[idx].obj_type-100];
                            else rapidchance = DefenseRapid[unit->obj_type-100][dunits[idx].obj_type-200];
                            rapidfire = MyRand (0, 999) < rapidchance;
                        }
                        else rapidfire = 0;
                        if (Rapidfire == 0) rapidfire = 0;
                    }
                }
            }
        }
        for (slot=0; slot<dnum; slot++)     // �������������
        {
            for (i=0; i<dobjs; i++) {
                rapidfire = 1;
                unit = &dunits[i];
                if (unit->slot_id == slot) {
                    // �������.
                    while (rapidfire) {
                        idx = MyRand (0, aobjs-1);
                        apower = UnitShoot (unit, d[slot].weap, &aunits[idx], &absorbed[0], &aloss, &dm, &dk );
                        shoots[1]++;
                        spower[1] += apower;
                        if (unit->obj_type < 200) { // ������ ���� �������� ��������� ���������.
                            if (aunits[idx].obj_type < 200) rapidchance = FleetRapid[unit->obj_type-100][aunits[idx].obj_type-100];
                            else rapidchance = DefenseRapid[unit->obj_type-100][aunits[idx].obj_type-200];
                            rapidfire = MyRand (0, 999) < rapidchance;
                        }
                        else rapidfire = 0;
                        if (Rapidfire == 0) rapidfire = 0;
                    }
                }
            }
        }

        // ������� �����?
        fastdraw = CheckFastDraw (aunits, aobjs, dunits, dobjs);

        // ��������� ���������� ������� � �������.
        aobjs -= WipeExploded (&aunits, aobjs);
        dobjs -= WipeExploded (&dunits, dobjs);

        strcpy (longstr1, nicenum(shoots[0]));
        strcpy (longstr2, nicenum(spower[0]));
        strcpy (longstr3, nicenum(absorbed[1]));
        printf ("<br><center>");
        printf ("The attacking fleet fires %s times with a total firepower of %s at the defender. The defending shields absorb %s damage", longstr1, longstr2, longstr3);
        printf ("<br>");
        strcpy (longstr1, nicenum(shoots[1]));
        strcpy (longstr2, nicenum(spower[1]));
        strcpy (longstr3, nicenum(absorbed[0]));
        printf ("In total, the defending fleet fires %s times with a total firepower of %s at the attacker. The attackers shields absorb %s damage", longstr1, longstr2, longstr3);
        printf ("</center>");
        
        printf ("<table border=1 width=100%%><tr>");
        for (slot=0; slot<anum; slot++) {
            GenSlot (aunits, slot, aobjs, a, d, 1, 0);
        }
        printf ("</tr></table>");
        printf ("<table border=1 width=100%%><tr>");
        for (slot=0; slot<dnum; slot++) {
            GenSlot (dunits, slot, dobjs, a, d, 0, 0);
        }
        printf ("</tr></table>");

        if (fastdraw) break;
    }
    
    // ���������� ���.
    if (aobjs > 0 && dobjs == 0){ 
        Plunder (CalcCargo (aunits, aobjs), met, crys, deut, &cm, &ck, &cd);

        strcpy (longstr1, nicenum(cm));
        strcpy (longstr2, nicenum(ck));
        strcpy (longstr3, nicenum(cd));
        printf ("<p> Атакующий выиграл битву!<br>");
        printf ("Он получает %s металла, %s кристалла и %s дейтерия.", longstr1, longstr2, longstr3);
        printf ("<br>");

    }
    else if (dobjs > 0 && aobjs == 0) { // ��������� ��������
        printf ("<p> Обороняющийся выиграл битву!<br>");
    }
    else    // �����
    {
        printf ("<p> Бой оканчивается вничью, оба флота возвращаются на свои планеты<br>");
    }

    moonchance = (int)((dm + dk) / 100000);
    if (moonchance > 20) moonchance = 20;

    strcpy (longstr1, nicenum(aloss));
    strcpy (longstr2, nicenum(dloss));
    printf ("<p><br>");
    printf ("Атакующий потерял %s единиц.<br>Обороняющийся потерял %s единиц.", longstr1, longstr2);
    strcpy (longstr1, nicenum(dm));
    strcpy (longstr2, nicenum(dk));
    printf ("<br>");
    printf ("Теперь на этих пространственных координатах находится %s металла и %s кристалла.", longstr1, longstr2);
    if (moonchance) { 
        printf ("<br>");
        printf ("Шанс появления луны составил %s %% ", nicenum(moonchance));
    }

    // �������������� �������.
    if (ExplodedDefenseTotal) {
        for (i=0; i<8; i++) {
            if (ExplodedDefense[i]) {
                if (d[0].def[i] < 10) {
                    for (n=0; n<ExplodedDefense[i]; n++) {
                        if ( MyRand (0, 99) < 70 ) { 
                            RepairDefense[i]++;
                            RepairDefenseTotal++;
                        }
                    }
                }
                else {
                    repairchance = MyRand (60, 80);
                    RepairDefense[i] = repairchance * ExplodedDefense[i] / 100;
                    RepairDefenseTotal += RepairDefense[i];
                }
            }
        }
    }

    if (RepairDefenseTotal) {
        printf ("<br>");
        for (i=0; i<8; i++) {
            if (RepairDefense[RepairMap[i]]) {
                if (sum > 0) printf (", ");
                printf ("%i %s", RepairDefense[RepairMap[i]], "DefenseNames[RepairMap[i]]");
                sum += RepairDefense[RepairMap[i]];
            }
        }
        printf (" были повреждены и находятся в ремонте.<br>");
    }
    
    free (aunits);
    free (dunits);        
}

// ==========================================================================================
// ������������� ������� ������ - �������� ������ �� �� � ������������ �� �� ��������.

typedef struct SimParam {
    char    name[32];
    char    string[64];
    unsigned long value;
} SimParam;
static SimParam *simargv;
static long simargc = 0;

// ������������� ������ ���� %EF%F0%E8%E2%E5%F2 � �������� ������.
static void hexize (char *string)
{
    int hexnum;
    char *temp, c, *oldstring = string;
    long length = (long)strlen (string), p = 0, digit = 0;
    temp = (char *)malloc (length + 1);
    if (temp == NULL) return;
    while (length--) {
        c = *string++;
        if (c == 0) break;
        if (c == '%') { 
            digit = 1;
        }
        else {
            if (digit == 1) {
                if (c <= '9') hexnum = (c - '0') << 4;
                else hexnum = (10 +(c - 'A')) << 4;
                digit = 2;
            }
            else if (digit == 2) {
                if (c <= '9') hexnum |= (c - '0');
                else hexnum |= 10 + (c - 'A');
                temp[p++] = (unsigned char)hexnum;
                digit = 0;
            }
            else temp[p++] = c;
        }
    }
    temp[p++] = 0;
    memcpy (oldstring, temp, p);
    free (temp);
}

static void AddSimParam (char *name, char *string)
{
    long i;

    // ���������, ���� ����� �������� ��� ����������, ������ �������� ��� ��������.
    for (i=0; i<simargc; i++) {
        if (!strcmp (name, simargv[i].name)) {
            strncpy (simargv[i].string, string, sizeof(simargv[i].string));
            simargv[i].value = strtoul (simargv[i].string, NULL, 10);
            return;
        }
    }

    // �������� ����� ��� ����� �������� � �������� ��������.
    hexize (string);
    simargv = (SimParam *)realloc (simargv, (simargc + 1) * sizeof (SimParam) );
    strncpy (simargv[simargc].name, name, sizeof (simargv[simargc].name) );
    strncpy (simargv[simargc].string, string, sizeof (simargv[simargc].string) );
    simargv[simargc].value = strtoul (simargv[simargc].string, NULL, 10);
    simargc ++;
}

static void PrintSimParams (void)
{
    long i;
    SimParam *p;
    for (i=0; i<simargc; i++) {
        p = &simargv[i];
        printf ( "%i: %s = %s (%i)<br>\n", i, p->name, p->string, p->value );
    }
    printf ("<hr/>");
}

// ��������� ���������.
static void ParseQueryString (char *str)
{
    int collectname = 1;
    char namebuffer[100], stringbuffer[100], c;
    long length, namelen = 0, stringlen = 0;
    memset (namebuffer, 0, sizeof(namebuffer));
    memset (stringbuffer, 0, sizeof(stringbuffer));
    if (str == NULL) return;
    length = (long)strlen (str);
    while (length--) {
        c = *str++;
        if ( c == '=' ) {
            collectname = 0;
        }
        else if (c == '&') { // �������� ��������.
            collectname = 1;
            if (namelen >0 && stringlen > 0) {
                AddSimParam (namebuffer, stringbuffer);
            }
            memset (namebuffer, 0, sizeof(namebuffer));
            memset (stringbuffer, 0, sizeof(stringbuffer));
            namelen = stringlen = 0;
        }
        else {
            if (collectname) {
                if (namelen < 31) namebuffer[namelen++] = c;
            }
            else {
                if (stringlen < 63) stringbuffer[stringlen++] = c;
            }
        }
    }
    // �������� ��������� ��������.
    if (namelen > 0 && stringlen > 0) AddSimParam (namebuffer, stringbuffer);
}

static SimParam *ParamLookup (char *name)
{
    SimParam *p = NULL;
    long i;
    for (i=0; i<simargc; i++) {
        if (!strcmp (simargv[i].name, name)) return &simargv[i];
    }
    return p;
}

static int GetSimParamI (char *name, int def)
{
    SimParam *p = ParamLookup (name);
    if (p == NULL) return def;
    else return p->value;
}

static char *GetSimParamS (char *name, char *def)
{
    SimParam *p = ParamLookup (name);
    if (p == NULL) return def;
    else return p->string;
}

void main(int argc, char **argv)
{
    Slot a[16], d[16];
    int anum = 0, dnum = 0;
    u64 met, crys, deut;

    memset (a, 0, sizeof (a));
    memset (d, 0, sizeof (d));

	if ( argc < 2 ) return;

	ParseQueryString ( argv[1] );
	//PrintSimParams ();

	// ����������� � ����� ������ � ������� ���� ��������� � �������������.
    {
        char query[1024], *db_prefix = GetSimParamS("db_prefix", "");
        int fleet_id = GetSimParamI("fleet_id", 0), planet_id = GetSimParamI("planet_id", 0);
        MYSQL *conn;
        MYSQL_RES *result;

        if ( fleet_id == 0 || planet_id == 0 ) return;

        conn = mysql_init(NULL);
        if(conn == NULL) { printf ("(ERROR): 1"); return; }

        if ( ! mysql_real_connect(conn, GetSimParamS("db_host", "localhost"), GetSimParamS("db_user", "root"), GetSimParamS("db_pass", "root"), GetSimParamS("db_name", "ogame"),0,NULL,0) ) { printf ("(ERROR): 2"); return; }

        // �������� ����� ��������.
        sprintf ( query, "SELECT * FROM %sfleet WHERE fleet_id = %i", db_prefix, fleet_id );
        mysql_query ( conn, query );
        result = mysql_store_result ( conn );
        if ( result == NULL ) { printf ("(ERROR): 3"); return; }

        {
            MYSQL_ROW row;
            unsigned int num_fields;
            unsigned int id;

            num_fields = mysql_num_fields(result);
            while ((row = mysql_fetch_row(result)))
            {
                for (id=0; id<14; id++) {
                    a[anum].fleet[id] = atoi ( row[12+id] );
                }
                a[anum].fleet[10] = 0;

                a[anum].g = 1;
                a[anum].s = 122;
                a[anum].p = 13;

                a[anum].weap = a[anum].shld = a[anum].armor = 8;

                anum++;
            }
        }

        // �������� ����� �����.
        sprintf ( query, "SELECT * FROM %splanets WHERE planet_id = %i", db_prefix, planet_id );
        mysql_query ( conn, query );
        result = mysql_store_result ( conn );
        if ( result == NULL ) { printf ("(ERROR): 4"); return; }

        {
            MYSQL_ROW row;
            unsigned int num_fields;
            unsigned int id;

            num_fields = mysql_num_fields(result);
            (row = mysql_fetch_row(result));
            {
                for (id=0; id<14; id++) {
                    d[dnum].fleet[id] = atoi ( row[40+id] );
                }
                for (id=0; id<8; id++) {
                    d[dnum].def[id] = atoi ( row[30+id] );
                }

                // ������� �� �������
                met = (u64)atof ( row[54] );
                crys = (u64)atof ( row[55] );
                deut = (u64)atof ( row[56] );

                d[dnum].g = atoi ( row[3] );
                d[dnum].s = atoi ( row[4] );
                d[dnum].p = atoi ( row[5] );

                d[dnum].weap = d[dnum].shld = d[dnum].armor = 10;

                dnum++;
            }
        }

        // ����� �� ���������.

        mysql_close(conn);
    }

    // ��������� ������� ������.
    SetDebrisOptions ( GetSimParamI ("did", 0), GetSimParamI ("fid", 30) );
    SetRapidfire ( GetSimParamI ("rf", 1) );

    // ������ ���.
	MySrand ((unsigned long)time(NULL));
	DoBattle (a, anum, d, dnum, met, crys, deut);
}
